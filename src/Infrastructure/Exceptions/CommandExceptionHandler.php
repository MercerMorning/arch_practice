<?php

namespace App\Infrastructure\Exceptions;

use App\Application\Commands\CommandInterface;
use App\Application\Commands\Move;
use \Exception;
use Throwable;

class CommandExceptionHandler implements ExceptionHandlerInterface
{
    const EXCEPTION_HANDLERS = [
        Move::class => [
            Exception::class => ExceptionHandler::class
        ]
    ];

    public function handle(CommandInterface $command, Throwable $exception)
    {
        $handler = $this->getExceptionHandler($command::class, $exception::class);
        return $handler->handle($command, $exception);
    }

    private function getExceptionHandler(string $commandType, string $exceptionClass): ExceptionHandlerInterface
    {
        $handlerClass = self::EXCEPTION_HANDLERS[$commandType][$exceptionClass];
        return new $handlerClass();
    }
}