<?php

namespace App\Todo\Application\Task;

use App\Todo\Domain\Repository\RepositoryInterface;

class CompleteTask
{
    private RepositoryInterface $repository;

    /**
     * CompleteTask constructor.
     * @param  RepositoryInterface  $repository
     */
    public function __construct(RepositoryInterface $repository)
    {
        $this->repository = $repository;
    }

    public function handle(int $taskId)
    {
        $task = $this->repository->findOne($taskId);

        $task->complete();

        $this->repository->save($task);

        return $task;
    }
}