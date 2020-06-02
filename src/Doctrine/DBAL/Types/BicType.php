<?php

declare(strict_types=1);

namespace App\Doctrine\DBAL\Types;

use App\Doctrine\DBAL\Objects\Bic;
use Doctrine\DBAL\Platforms\AbstractPlatform;
use Doctrine\DBAL\Types\Type;

class BicType extends Type
{
    public const TYPE = 'bic';
    public const LENGTH = 11;

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
        return $value->__toString();
    }

    public function convertToPHPValue($value, AbstractPlatform $platform)
    {
        return new Bic($value);
    }
}
