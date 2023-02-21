<?php

namespace App\Infrastructure\Exceptions;

use App\Application\Commands\CommandInterface;
use App\Application\Commands\RepeatCommand;
use App\Infrastructure\Queue\QueueStorage;
use Throwable;

class RuntimeExceptionHandler implements ExceptionHandlerInterface
{
    public function handle(CommandInterface $command, Throwable $exception)
    {
        QueueStorage::push(new RepeatCommand($command));
    }
}