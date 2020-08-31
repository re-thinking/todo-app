<?php

namespace App\Todo\Domain\Service\Validation;

class Service implements ServiceInterface
{
    /**
     * @var Validator[]
     */
    private array $validators = [];

    public function validate(string $name, ?\DateTimeInterface $dueDate = null): void
    {
        array_walk($this->validators, fn(Validator $validator) => $validator->validate($name, $dueDate));
    }

    public function addValidator(Validator $validator): void
    {
        $this->validators[] = $validator;
    }
}