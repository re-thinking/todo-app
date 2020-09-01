<?php

namespace App\Todo\Application\Task;

use App\Todo\Domain\Repository\RepositoryInterface;

class Query
{
    private RepositoryInterface $repository;

    /**
     * Query constructor.
     * @param  RepositoryInterface  $repository
     */
    public function __construct(RepositoryInterface $repository)
    {
        $this->repository = $repository;
    }

    public function listTasks()
    {
        return $this->repository->findAll();
    }

    public function showTask(int $taskId)
    {
        return $this->repository->findOne($taskId);
    }
}