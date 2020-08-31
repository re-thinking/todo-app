<?php

namespace App\Todo\Domain\ValueObject;

class Opened extends Status
{
    public function complete(): Status
    {
        return new Completed();
    }

    public function __toString()
    {
        return self::OPENED;
    }
}