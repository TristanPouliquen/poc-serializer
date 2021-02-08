# Field level normalization

This PoC is here to show you how we could implement field-level normalization for our API, allowing us
to plug custom Symfony normalizers for certain type of data we want to manage and canonicalise.

## What do we need to make it work?
To be able to normalize/denormalize correctly values in our API, we need to add a new layer of
objects representing the data we manage in our API ()(eg: [`Iban`](./src/Serializer/Objects/Iban.php)).
We also need to create Doctrine Types to tell Doctrine how to store/instantiate our canonical objects in the database
(eg: [`IbanType`](./src/Doctrine/DBAL/Types/IbanType.php)).

We then have to correctly type hint the object (entity or DTO) where we are managing this data:
```php
class BankAccount
{
    private $iban;
    
    /** 
     * The return type hint is essential, this is what the Symfony serializer uses 
     * to determine how to normalize this value
     */
    public function getIban(): Iban
    {
        return $this->iban;
    }

    /**
     * The argument type hint is essential, this is what the Symfony serializer uses
     * to determine how to denormalize this value
     */
    public function setIban(Iban $iban): self
    {
        $this->iban = $iban;
    
        return $this;
    }
}
```

By doing that, we can now plug in our custom normalizer
(eg: [`IbanNormalizer`](./src/Serializer/Normalizer/IbanNormalizer.php)).

## What does it do?
Creating a custom Normalizer for our data allows us to:
- Offer a more robust API that does not break or respond badly in case of non canonical values;
- Store a canonicalised version of the data in our database, easing treatment;
- Relieve the developer of the need to know what is the right canonical form and of the effort to convert
the data he is sending to our API;
- Expose data in a more user-friendly way.

For instance, if you run the given app and try to create a `BankAccount`, the API will transparently
accept any form for the IBAN or BIC field, trim all spaces, switch it to uppercase before it is passed down
the request lifecycle.
The validators will now only see the canonicalised version of your user's input, and you will have the canonicalised
value correctly stored in your database.

For demonstration purposes, the IBAN field is normalised by shuffling the string.

## Implementation details
I tried to standardise all this mechanism:
- by creating a [`TypeObjectInterface`](./src/Serializer/Objects/TypeObjectInterface.php) that
asks for a `__toString` method and a `normalize` method;
- by creating a [`TypeObjectNormalizer`](./src/Serializer/Normalizer/TypeObjectNormalizer.php) that
normalizes all `TypeObjectInterface` objects through their `normalize` method;
- by making my object normalizers like `IbanNormalizer` extend the `TypeObjectNormalizer`, to automatically
normalize with the `normalize` method, but giving the possibility of easily override this behaviour if need be
(even if this should rather be done in the `normalize` method of the object itself).

The presence of the `__toString` method allows us to still profit from the Symfony validators seamlessly.  
All string validators also accept objects that have a `__toString` method defined.
