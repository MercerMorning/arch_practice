<?php

declare(strict_types=1);

namespace Tests\Unit\Infrastructure\Exception;

use App\Application\Commands\LoggerCommand;
use App\Application\Commands\Move;
use App\Application\Commands\RepeatCommand;
use App\Application\Commands\SecondRepeatCommand;
use App\Domain\MovableInterface;
use App\Infrastructure\Exceptions\CommandExceptionHandler;
use App\Infrastructure\Exceptions\ExceptionHandler;
use App\Infrastructure\Queue\QueueStorage;
use ErrorException;
use Exception;
use http\Exception\InvalidArgumentException;
use Monolog\Level;
use PharException;
use PHPUnit\Framework\TestCase;
use RuntimeException;

class CommandExceptionHandlerTest extends TestCase
{
    public function setUp(): void
    {
        $this->commandExceptionHandler = new CommandExceptionHandler();
    }

    public function testExecuteWithMoveException(): void
    {
        $command = new Move($this->createMock(MovableInterface::class));
        $result = $this->commandExceptionHandler->handle($command, new Exception());
        $this->assertEquals(ExceptionHandler::class, $result);
    }

    public function testExecuteWithMoveRuntimeException(): void
    {
        $queue = new QueueStorage();
        $command = new Move($this->createMock(MovableInterface::class));
        $asserted = new RepeatCommand($command);
        $queue::push($command);
        $this->commandExceptionHandler->handle($command, new RuntimeException());
        $this->assertEquals($asserted, $queue->take());
    }

    public function testExecuteWithMoveRepeatRuntimeException(): void
    {
        $queue = new QueueStorage();
        $command = new Move($this->createMock(MovableInterface::class));
        $asserted = new LoggerCommand(Level::Warning, new RuntimeException());
        $this->commandExceptionHandler->handle($command, new RuntimeException());
        $command = $queue->take();
        $this->commandExceptionHandler->handle($command, new RuntimeException());
        $this->assertEquals($asserted, $queue->take());
    }

    public function testExecuteWithMoveRepeatErrorRuntimeException(): void
    {
        $queue = new QueueStorage();
        $command = new Move($this->createMock(MovableInterface::class));
        $asserted = new SecondRepeatCommand(new RepeatCommand($command));
        $this->commandExceptionHandler->handle($command, new ErrorException());
        $command = $queue->take();
        $this->commandExceptionHandler->handle($command, new ErrorException());
        $command = $queue->take();
        $this->assertEquals($asserted, $command);
    }

    public function testExecuteWithMoveSecondRepeatErrorRuntimeException(): void
    {
        $queue = new QueueStorage();
        $command = new Move($this->createMock(MovableInterface::class));
        $asserted = new LoggerCommand(Level::Warning, new ErrorException());
        $this->commandExceptionHandler->handle($command, new ErrorException());
        $command = $queue->take();
        $this->commandExceptionHandler->handle($command, new ErrorException());
        $command = $queue->take();
        $this->commandExceptionHandler->handle($command, new ErrorException());
        $command = $queue->take();
        $this->assertEquals($asserted, $command);
    }

    public function testExecuteWithInvalidArgumentException(): void
    {
        $command = new Move($this->createMock(MovableInterface::class));
        $result = $this->commandExceptionHandler->handle($command, new InvalidArgumentException());
        $this->assertEquals(ExceptionHandler::class, $result);
    }

    public function testExecuteWithExceptionInMoveCommand(): void
    {
        $command = new Move($this->createMock(MovableInterface::class));
        $result = $this->commandExceptionHandler->handle($command, new PharException());
        $this->assertEquals(ExceptionHandler::class, $result);
    }
}

