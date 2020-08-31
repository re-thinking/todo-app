<?php

namespace App\Todo\Application\Task;

use App\Todo\Domain\Opened;
use App\Todo\Domain\Repository\RepositoryInterface;
use App\Todo\Domain\Service\Validation;

class CreateTask
{
    private RepositoryInterface $repository;

    private Validation\ServiceInterface $validator;

    /**
     * CreateTask constructor.
     * @param  RepositoryInterface  $repository
     * @param  Validation\ServiceInterface  $validator
     */
    public function __construct(RepositoryInterface $repository, Validation\ServiceInterface $validator)
    {
        $this->repository = $repository;
        $this->validator = $validator;
    }

    public function handle(string $name, ?\DateTimeImmutable $dueDate)
    {
        $this->validator->validate($name, $dueDate);

        $task = new Opened($name, $dueDate);

        $this->repository->save($task);

        return $task;
    }
}