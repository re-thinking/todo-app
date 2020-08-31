<?php

namespace App\Tests\Todo\Service;

use App\Todo\Domain\Exceptions\ValidationException;
use App\Todo\Domain\Service\Validation\NameNotEmpty;
use PHPUnit\Framework\TestCase;

class NameNotEmptyTest extends TestCase
{
    public function testValidate()
    {
        $validator = new NameNotEmpty();

        $this->expectException(ValidationException::class);
        $validator->validate('');

        $this->assertNull($validator->validate('Test', new \DateTimeImmutable("+1 minute")));
        $this->assertNull($validator->validate('Test'));
    }
}