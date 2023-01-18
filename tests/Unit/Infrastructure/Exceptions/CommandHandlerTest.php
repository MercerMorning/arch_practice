<?php

use App\Application\Commands\Move;
use App\Domain\MovableInterface;
use App\Infrastructure\Exceptions\CommandExceptionHandler;
use App\Infrastructure\Exceptions\ExceptionHandler;
use App\Infrastructure\Exceptions\RuntimeExceptionHandler;
use PHPUnit\Framework\TestCase;

class CommandHandlerTest extends TestCase
{
    public function testGetHandlerMoveBaseException()
    {
        $handler = new CommandExceptionHandler();
        $result = $handler->handle(new Move($this->createMock(MovableInterface::class)), new Exception());
        $this->assertSame(ExceptionHandler::class, $result);
    }
}