<?php

namespace App\Doctrine\Type;

use App\Todo\Domain\ValueObject;
use Doctrine\DBAL\Platforms\AbstractPlatform;
use Doctrine\DBAL\Types\Type;

class Status extends Type
{
    const NAME = 'status';
    /**
     * @inheritDoc
     */
    public function getSQLDeclaration(array $fieldDeclaration, AbstractPlatform $platform)
    {
        return $platform->getVarcharTypeDeclarationSQL([]);
    }

    public function convertToPHPValue($value, AbstractPlatform $platform)
    {
        if ($value === ValueObject\Status::OPENED) {
            return new ValueObject\Opened();
        }

        if ($value === ValueObject\Status::COMPLETED) {
            return new ValueObject\Completed();
        }

        throw new \Exception(sprintf('Unknown status "%s", expected one of "%s"', $value, implode('", "', [ValueObject\Status::OPENED, ValueObject\Status::COMPLETED])));
    }

    public function convertToDatabaseValue($value, AbstractPlatform $platform)
    {
        return (string) $value;
    }

    /**
     * @inheritDoc
     */
    public function getName()
    {
        return self::NAME;
    }
}