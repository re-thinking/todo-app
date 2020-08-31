<?php

namespace App\Todo\Domain\ValueObject;

abstract class Status
{
    const OPENED = 'opened';
    const COMPLETED = 'completed';

    public function open(): Status
    {
        throw new \LogicException("Task is already opened");
    }

    public function complete(): Status
    {
        throw new \LogicException("Task is already completed");
    }

    abstract public function __toString();
}
