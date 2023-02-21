<?php

namespace App\Infrastructure\Exceptions;

use App\Application\Commands\CommandInterface;
use App\Application\Commands\RepeatCommand;
use App\Application\Commands\SecondRepeatCommand;
use App\Infrastructure\Queue\QueueStorage;
use Throwable;

class RepeatErrorExceptionHandler implements ExceptionHandlerInterface
{
    public function handle(CommandInterface $command, Throwable $exception)
    {
        QueueStorage::push(new SecondRepeatCommand($command));
    }
}