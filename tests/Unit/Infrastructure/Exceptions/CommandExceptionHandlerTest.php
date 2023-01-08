<?php

declare(strict_types=1);

namespace Tests\Unit\Infrastructure\Exception;

use App\Application\Commands\CommandInterface;
use App\Infrastructure\Exceptions\CommandExceptionHandler;
use App\Infrastructure\Queue\QueueStorageInterface;
use PHPUnit\Framework\TestCase;

class CommandExceptionHandlerTest extends TestCase
{
    public function setUp()
    {
        $this->command                 = $this->createMock(CommandInterface::class);

        $this->queueStorage            = $this->createMock(QueueStorageInterface::class);
        $this->commandExceptionHandler = new CommandExceptionHandler($this->queueStorage);
    }

    public function testExecuteWithException(): void
    {
        $this->command->expects($this->once())
            ->method('execute');
        $this->queueStorage->expects($this->once())
            ->method('push')
            ->with($this->command);

        $this->commandExceptionHandler->handle($this->command, new \Exception('test'));
    }
}

