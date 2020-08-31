<?php

namespace App\Todo\Application\Task;

use App\Todo\Domain\Repository\RepositoryInterface;
use App\Todo\Domain\Task;

class ShowTask
{
    private RepositoryInterface $repository;

    /**
     * ShowTask constructor.
     * @param  RepositoryInterface  $repository
     */
    public function __construct(RepositoryInterface $repository)
    {
        $this->repository = $repository;
    }


    public function handle(int $taskId): Task
    {
        return $this->repository->findOne($taskId);
    }
}