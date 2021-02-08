<?php

namespace App\Doctrine\DBAL\Types;

use App\Doctrine\DBAL\Objects\Iban;
use Doctrine\DBAL\Platforms\AbstractPlatform;
use Doctrine\DBAL\Types\Type;

class IbanType extends Type
{
    public const TYPE = 'iban';
    public const LENGTH = 31;

    /**
     * @inheritdoc
     */
    public function getSQLDeclaration(array $fieldDeclaration, AbstractPlatform $platform)
    {
        $fieldDeclaration['length'] = static::LENGTH;
        return $platform->getVarcharTypeDeclarationSQL($fieldDeclaration);
    }

    public function getName()
    {
        return static::TYPE;
    }

    /**
     * @inheritdoc
     */
    public function requiresSQLCommentHint(AbstractPlatform $platform)
    {
        return true;
    }

    public function convertToDatabaseValue($value, AbstractPlatform $platform)
    {
        return $value->getIban();
    }

    public function convertToPHPValue($value, AbstractPlatform $platform)
    {
        return new Iban($value);
    }
}
