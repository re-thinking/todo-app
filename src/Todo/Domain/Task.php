<?php

namespace App\Todo\Domain;

use App\Todo\Domain\ValueObject\Opened;
use App\Todo\Domain\ValueObject\Status;

class Task implements \JsonSerializable
{
    private ?int $id;

    private string $name;

    private Status $status;

    private ?\DateTimeImmutable $dueDate;

    private ?\DateTimeImmutable $createdAt;

    private ?\DateTimeImmutable $updatedAt;

    public function __construct(string $name, \DateTimeImmutable $dueDate = null)
    {
        $this->name = $name;

        $this->dueDate = $dueDate;

        $this->status = new Opened();
    }

    public function complete()
    {
        $this->status = $this->status->complete();
    }

    public function redo()
    {
        $this->status = $this->status->open();
    }

    public function edit(string $name, ?\DateTimeImmutable $dueDate)
    {
        $this->name = $name;
        $this->dueDate = $dueDate;
    }

    public function jsonSerialize()
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'due_date' => $this->dueDate ? $this->dueDate->format('Y-m-d H:i:s') : null,
            'status' => (string) $this->status
        ];
    }
}