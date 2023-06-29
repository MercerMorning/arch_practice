<?php

namespace App\Infrastructure\Queue\Statements;

use App\Infrastructure\Exceptions\ExceptionHandlerInterface;
use App\Infrastructure\Queue\QueueStorageInterface;

interface StatementInterface
{
    public function handle(
        QueueStorageInterface $queueStorage,
        ExceptionHandlerInterface $exceptionHandler
    ): StatementInterface|null;
}