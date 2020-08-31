<?php

namespace App\Todo\Domain\Service\Validation;

interface ServiceInterface
{
    public function validate(string $name, ?\DateTimeImmutable $dueDate = null): void;

    public function addValidator(Validator $validator): void;
}