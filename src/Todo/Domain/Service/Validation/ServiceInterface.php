<?php

namespace App\Todo\Domain\Service\Validation;

interface ServiceInterface
{
    public function validate(string $name, ?\DateTimeInterface $dueDate = null): void;

    public function addValidator(Validator $validator): void;
}