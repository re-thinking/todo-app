<?php

namespace App\Todo\Domain\Service\Validation;

use App\Todo\Domain\Exceptions\InvalidDueDateException;

class DueDateIsFuture implements Validator
{
    public function validate(string $name, ?\DateTimeInterface $dueDate = null)
    {
        if (is_null($dueDate)) {
            return;
        }
        if ($dueDate < new \DateTimeImmutable()) {
            throw new InvalidDueDateException();
        }
    }
}