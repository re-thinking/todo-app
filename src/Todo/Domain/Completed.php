<?php

namespace App\Todo\Domain;

class Completed extends Task
{
    public const STATUS = self::COMPLETED;

    protected function __construct(string $name, ?\DateTimeImmutable $dueDate = null)
    {
        parent::__construct($name, $dueDate);
    }
}