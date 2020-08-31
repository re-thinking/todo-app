<?php

namespace App\Todo\Domain\Service\Validation;

interface Validator
{
    public function validate(string $name, ?\DateTimeInterface $dueDate = null);
}