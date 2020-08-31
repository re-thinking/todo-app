<?php

namespace App\Todo\Domain;

use App\Todo\Domain\ValueObject\Opened;
use App\Todo\Domain\ValueObject\Status;

class Task implements \JsonSerializable
{
    private ?int $id;

    private string $name;

    private Status $status;

    private ?\DateTimeInterface $dueDate;

    private \DateTimeInterface $createdAt;

    private \DateTimeInterface $updatedAt;

    public function __construct(string $name, \DateTimeInterface $dueDate = null)
    {
        $this->name = $name;

        $this->dueDate = $dueDate;

        $this->status = new Opened();

        $this->createdAt = $this->updatedAt = new \DateTimeImmutable();
    }

    public function complete()
    {
        $this->status = $this->status->complete();

        $this->updatedAt = new \DateTimeImmutable();
    }

    public function open()
    {
        $this->status = $this->status->open();

        $this->updatedAt = new \DateTimeImmutable();
    }

    public function edit(string $name, ?\DateTimeInterface $dueDate)
    {
        $this->name = $name;
        $this->dueDate = $dueDate;

        $this->updatedAt = new \DateTimeImmutable();
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

    public function getId()
    {
        return $this->id;
    }
}