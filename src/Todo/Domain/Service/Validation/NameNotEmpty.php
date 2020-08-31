<?php

namespace App\Todo\Domain\Service\Validation;

use App\Todo\Domain\Exceptions\EmptyNameException;

class NameNotEmpty implements Validator
{
    public function validate(string $name, ?\DateTimeImmutable $dueDate = null)
    {
        if (empty($name)) {
            throw new EmptyNameException();
        }
    }
}