<?php

namespace App\Infrastructure\Exceptions;

use App\Application\Commands\CommandInterface;
use App\Application\Commands\Move;
use App\Application\Commands\RepeatCommand;
use App\Application\Commands\SecondRepeatCommand;
use ErrorException;
use Exception;
use http\Exception\InvalidArgumentException;
use RuntimeException;
use Throwable;

class CommandExceptionHandler implements ExceptionHandlerInterface
{
    const COMMAND_EXCEPTION_HANDLERS = [
        Move::class => [
            Exception::class => ExceptionHandler::class,
            RuntimeException::class => RuntimeExceptionHandler::class,
            ErrorException::class => ErrorExceptionHandler::class
        ],
        RepeatCommand::class => [
            RuntimeException::class => ExceptionHandlerWithLogging::class,
            ErrorException::class => RepeatErrorExceptionHandler::class
        ],
        SecondRepeatCommand::class => [
            ErrorException::class => ExceptionHandlerWithLogging::class,
        ],

    ];

    const EXCEPTION_HANDLERS = [
        InvalidArgumentException::class => ExceptionHandler::class,
    ];

    const COMMAND_HANDLERS = [
        Move::class => ExceptionHandler::class,
    ];


    public function handle(CommandInterface $command, Throwable $exception)
    {
        $handler = $this->getExceptionHandler($command::class, $exception::class);
        return $handler->handle($command, $exception);
    }

    private function getExceptionHandler(string $commandType, string $exceptionClass): ExceptionHandlerInterface
    {
        $handlerClass =
            self::COMMAND_EXCEPTION_HANDLERS[$commandType][$exceptionClass]
            ?? self::EXCEPTION_HANDLERS[$exceptionClass]
            ?? self::COMMAND_HANDLERS[$commandType];
        return new $handlerClass();
    }
}