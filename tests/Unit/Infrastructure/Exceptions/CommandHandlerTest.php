<?php

use App\Application\Commands\Move;
use App\Infrastructure\Exceptions\CommandHandler;
use App\Infrastructure\Exceptions\ExceptionHandler;
use PHPUnit\Framework\TestCase;

class CommandHandlerTest extends TestCase
{
    public function testGetHandlerMoveBaseException()
    {
        $handler = new CommandHandler();
        $result = $handler->handle(Move::class, new Exception());
        $this->assertSame(ExceptionHandler::class, $result);
    }
}