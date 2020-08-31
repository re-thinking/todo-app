<?php

namespace App\Messages;

class TaskMessage
{
    private int $id;

    /**
     * TaskMessage constructor.
     * @param  int  $id
     */
    public function __construct(int $id)
    {
        $this->id = $id;
    }

    /**
     * @return int
     */
    public function getId(): int
    {
        return $this->id;
    }
}