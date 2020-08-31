<?php

namespace App\Todo\Domain\Exceptions;

class EmptyNameException extends ValidationException
{
    public function __construct()
    {
        parent::__construct('Name can\'t be empty');
    }
}
