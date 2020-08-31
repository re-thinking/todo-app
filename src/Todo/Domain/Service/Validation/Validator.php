<?php

namespace App\Todo\Domain\Service\Validation;

interface Validator
{
    public function validate(string $name, ?\DateTimeImmutable $dueDate = null);
}