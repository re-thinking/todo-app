<?php

namespace App\Todo\Domain\Exceptions;

class InvalidDueDateException extends ValidationException
{
    public function __construct()
    {
        parent::__construct("Due date can't be in past");
    }
}