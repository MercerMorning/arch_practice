<?php

namespace App\Infrastructure\Exceptions;

use App\Application\Commands\CheckCollisionCommand;
use App\Application\Commands\CommandInterface;
use App\Application\Commands\Move;
use App\Application\Commands\RepeatCommand;
use App\Application\Commands\SecondRepeatCommand;
use App\Application\Exceptions\CollisionException;
use ErrorException;
use \Exception;
use RuntimeException;
use Throwable;

class CommandExceptionHandler implements ExceptionHandlerInterface
{
    const EXCEPTION_HANDLERS = [
        Move::class => [
            Exception::class => ExceptionHandler::class,
            RuntimeException::class => RuntimeExceptionHandler::class,
            ErrorException::class => ErrorExceptionHandler::class
        ],
        CheckCollisionCommand::class => [
            CollisionException::class => ExceptionHandler::class,
        ],
        RepeatCommand::class => [
            RuntimeException::class => ExceptionHandlerWithLogging::class,
            ErrorException::class => RepeatErrorExceptionHandler::class
        ],
        SecondRepeatCommand::class => [
            ErrorException::class => ExceptionHandlerWithLogging::class,
        ],
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