<?php

declare(strict_types=1);

namespace Tests\Unit\Infrastructure\Exception;

use App\Application\Commands\CommandInterface;
use App\Application\Commands\Move;
use App\Application\Commands\RepeatCommand;
use App\Domain\MovableInterface;
use App\Infrastructure\Exceptions\CommandExceptionHandler;
use App\Infrastructure\Queue\QueueStorage;
use App\Infrastructure\Queue\QueueStorageInterface;
use PHPUnit\Framework\TestCase;
use RuntimeException;

class CommandExceptionHandlerTest extends TestCase
{
    public function setUp(): void
    {
        $this->commandExceptionHandler = new CommandExceptionHandler();
    }

    public function testExecuteWithException(): void
    {
        $queue = new QueueStorage();
        $command = new Move($this->createMock(MovableInterface::class));
        $asserted = new RepeatCommand($command);
        $queue::push($command);
        $this->commandExceptionHandler->handle($command, new RuntimeException());
        $this->assertEquals($asserted, $queue->take());
    }
}

