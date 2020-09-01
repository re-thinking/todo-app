<?php

namespace App\Todo\Application\Task;

use App\Todo\Domain\Repository\RepositoryInterface;
use App\Todo\Domain\Service;
use App\Todo\Domain\Task;

class Command
{
    private RepositoryInterface $repository;

    private Service\Validation\ServiceInterface $validator;

    public function __construct(RepositoryInterface $repository, Service\Validation\ServiceInterface $validator)
    {
        $this->repository = $repository;
        $this->validator = $validator;
    }

    public function completeTask(int $taskId): Task
    {
        $task = $this->repository->findOne($taskId);

        $task->complete();

        $this->repository->save($task);

        return $task;
    }

    public function openTask(int $taskId): Task
    {
        $task = $this->repository->findOne($taskId);

        $task->open();

        $this->repository->save($task);

        return $task;
    }

    public function createTask(string $name, ?\DateTimeInterface $dueDate = null): Task
    {
        $this->validator->validate($name, $dueDate);

        $task = new Task($name, $dueDate);

        $this->repository->save($task);

        return $task;
    }

    public function editTask(int $taskId, string $name, ?\DateTimeInterface $dueDate = null): Task
    {
        $this->validator->validate($name, $dueDate);

        $task = $this->repository->findOne($taskId);

        $task->edit($name, $dueDate);

        $this->repository->save($task);

        return $task;
    }

    public function deleteTask(int $taskId): void
    {
        $this->repository->destroy($taskId);
    }
}