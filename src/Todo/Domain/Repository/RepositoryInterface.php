<?php

namespace App\Todo\Domain\Repository;

use App\Todo\Domain\Task;

interface RepositoryInterface
{
    public function findAll(): array;

    public function findOne(int $id): Task;

    public function save(Task $task): void;

    public function findCompleted(): array;

    public function findOpened(): array;

    public function destroy(int $id): void;
}