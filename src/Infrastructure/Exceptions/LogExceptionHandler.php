<?php

namespace App\Infrastructure\Exceptions;

use App\Application\Commands\CommandInterface;
use App\Application\Commands\RepeatCommand;
use App\Application\Commands\SecondRepeatCommand;
use App\Infrastructure\Queue\QueueStorage;
use Throwable;

class LogExceptionHandler implements ExceptionHandlerInterface
{
    public function handle(CommandInterface $command, Throwable $exception)
    {
        //TODO: сделать запись в лог
//        QueueStorage::push(new SecondRepeatCommand($command));
    }
}