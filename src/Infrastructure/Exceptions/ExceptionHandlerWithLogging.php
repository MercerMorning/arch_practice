<?php

namespace App\Infrastructure\Exceptions;

use App\Application\Commands\CommandInterface;
use App\Application\Commands\LoggerCommand;
use App\Infrastructure\Queue\QueueStorage;
use Monolog\Level;
use Throwable;

class ExceptionHandlerWithLogging implements ExceptionHandlerInterface
{
    public function handle(CommandInterface $command, Throwable $exception)
    {
        QueueStorage::push(new LoggerCommand(Level::Warning, $exception));
    }
}