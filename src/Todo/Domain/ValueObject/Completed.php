<?php

namespace App\Todo\Domain\ValueObject;

class Completed extends Status
{
    public function open(): Status
    {
        return new Opened();
    }

    public function __toString()
    {
        return self::COMPLETED;
    }
}