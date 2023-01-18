<?php

namespace App\Infrastructure\Queue;

use App\Infrastructure\Exceptions\CommandHandlerInterface;
use App\Infrastructure\Exceptions\ExceptionHandlerInterface;
use \Exception;

class QueueListener
{
    private QueueStorageInterface $queueStorage;
    public ExceptionHandlerInterface $errorHandler;

    public function __construct(QueueStorageInterface $queueStorage, ExceptionHandlerInterface $errorHandler)
    {
        $this->queueStorage = $queueStorage;
        $this->errorHandler = $errorHandler;
    }

    public function listen(): void
    {
        while ($queueItem = $this->queueStorage->take()) {
            try {
                $queueItem->execute();
            } catch (Exception $exception) {
                $this->errorHandler->handle($queueItem, $exception);
            }
        }
    }
}