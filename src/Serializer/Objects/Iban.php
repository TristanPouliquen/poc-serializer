<?php
declare(strict_types = 1);

namespace App\Serializer\Objects;

class Iban implements TypeObjectInterface
{
    private $iban;

    public function __construct(string $iban)
    {
        $this->iban = $iban;
    }

    public function getIban(): string
    {
        return $this->iban;
    }

    public function __toString() {
        return $this->iban;
    }

    public function normalize(): string
    {
        return strtoupper($this->__toString());
    }
}
