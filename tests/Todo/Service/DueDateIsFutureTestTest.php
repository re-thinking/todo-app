<?php

namespace App\Tests\Todo\Service;

use App\Todo\Domain\Exceptions\ValidationException;
use App\Todo\Domain\Service\Validation\DueDateIsFuture;
use PHPUnit\Framework\TestCase;

class DueDateIsFutureTestTest extends TestCase
{
    public function testValidate()
    {
        $validator = new DueDateIsFuture();

        $this->expectException(ValidationException::class);
        $validator->validate('', new \DateTimeImmutable('-1 hour'));

        $this->assertNull($validator->validate('', new \DateTimeImmutable("+1 minute")));
        $this->assertNull($validator->validate(''));
    }
}