<?php

namespace App\Tests\Todo\Domain;

use App\Todo\Domain\Task;
use PHPUnit\Framework\TestCase;

class TaskTest extends TestCase
{
    public function testItFailsOnTryingToOpenAlreadyOpenedTask()
    {
        $task = new Task('Test task');

        $this->expectException(\LogicException::class);

        $task->open();
    }

    public function testItFailsOnTryingToCompleteAlreadyCompletedTask()
    {
        $task = new Task('Test task');
        $task->complete();

        $this->expectException(\LogicException::class);

        $task->complete();
    }
}