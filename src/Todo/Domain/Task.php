<?php

namespace App\Todo\Domain;

abstract class Task implements \JsonSerializable
{
    const COMPLETED = 'completed';

    const OPENED = 'opened';

    const STATUS = self::OPENED;

    private $id;

    private string $name;

    private ?\DateTimeImmutable $dueDate;

    private $createdAt;

    private $updatedAt;

    public function __construct(string $name, \DateTimeImmutable $dueDate = null)
    {
        //todo: set status Opened
        $this->name = $name;

        $this->dueDate = $dueDate;
    }

    public function complete()
    {
        $completed = new Completed($this->name, $this->dueDate);
        $completed->id = $this->id;

        return $completed;
    }

    public function redo()
    {
        $opened = new Opened($this->name, $this->dueDate);
        $opened->id = $this->id;

        return $opened;
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
            'status' => static::STATUS
        ];
    }
}