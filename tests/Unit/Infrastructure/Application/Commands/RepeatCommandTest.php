<?php

declare(strict_types=1);

namespace Tests\Unit\Application\Commands;

use App\Application\Commands\CommandInterface;
use App\Application\Commands\RepeatCommand;
use PHPUnit\Framework\TestCase;

class RepeatCommandTest extends TestCase
{
    public function setUp(): void
    {
        $this->command = $this->createMock(CommandInterface::class);
        $this->command->method('execute')->willReturn('test');
        $this->repeat = new RepeatCommand($this->command);
    }

    public function testExecute(): void
    {
        $this->assertEquals('test', $this->repeat->execute());
    }
}