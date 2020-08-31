<?php

namespace App\Todo\Application\Task;

use App\Todo\Domain\Repository\RepositoryInterface;

class ListTasks
{
    private RepositoryInterface $repository;

    /**
     * ListTasks constructor.
     * @param  RepositoryInterface  $repository
     */
    public function __construct(RepositoryInterface $repository)
    {
        $this->repository = $repository;
    }

    public function handle()
    {
        return $this->repository->findAll();
    }
}