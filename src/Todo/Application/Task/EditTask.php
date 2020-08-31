<?php

namespace App\Todo\Application\Task;

use App\Todo\Domain\Repository\RepositoryInterface;
use App\Todo\Domain\Service\Validation;

class EditTask
{
    private RepositoryInterface $repository;

    private Validation\ServiceInterface $validator;

    /**
     * EditTask constructor.
     * @param  RepositoryInterface  $repository
     * @param  Validation\ServiceInterface  $validator
     */
    public function __construct(RepositoryInterface $repository, Validation\ServiceInterface $validator)
    {
        $this->repository = $repository;
        $this->validator = $validator;
    }

    public function handle(int $taskId, string $name, ?\DateTimeInterface $dueDate)
    {
        $this->validator->validate($name, $dueDate);

        $task = $this->repository->findOne($taskId);

        $task->edit($name, $dueDate);

        $this->repository->save($task);

        return $task;
    }
}