<?php

namespace App\Infrastructure\Queue\Statements;

use App\Application\Commands\MoveToCommand;
use App\Application\Commands\QueueStopCommand;
use App\Infrastructure\Exceptions\ExceptionHandlerInterface;
use App\Infrastructure\Queue\QueueStorageInterface;
use \Exception;

class Finished implements StatementInterface
{public function __construct()
    {

    }
    public function handle(
        QueueStorageInterface $queueStorage,
        ExceptionHandlerInterface $exceptionHandler
    ): StatementInterface|null
    {
        return null;
    }
}