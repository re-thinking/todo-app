<?php

namespace App\Todo\Application\Task;

use App\Todo\Domain\Repository\RepositoryInterface;

class DeleteTask
{
    private RepositoryInterface $repository;

    /**
     * DeleteTask constructor.
     * @param  RepositoryInterface  $repository
     */
    public function __construct(RepositoryInterface $repository)
    {
        $this->repository = $repository;
    }

    public function handle(int $taskId)
    {
        $this->repository->destroy($taskId);
    }
}