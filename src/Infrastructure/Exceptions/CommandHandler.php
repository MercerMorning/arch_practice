<?php

namespace App\Infrastructure\Exceptions;

use App\Application\Commands\Move;
use \Exception;
use Throwable;

class CommandHandler implements CommandHandlerInterface
{
    const EXCEPTION_HANDLERS = [
        Move::class => [
            Exception::class => ExceptionHandler::class
        ]
    ];

    public function handle(string $commandType, Throwable $exception)
    {
        $handler = $this->getExceptionHandler($commandType, $exception::class);
        return $handler->handle($exception);
    }

    private function getExceptionHandler(string $commandType, string $exceptionClass): ExceptionHandlerInterface
    {
        $handlerClass = self::EXCEPTION_HANDLERS[$commandType][$exceptionClass];
        return new $handlerClass();
    }
}