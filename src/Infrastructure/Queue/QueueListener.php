<?php

namespace App\Infrastructure\Queue;

use App\Infrastructure\Exceptions\HandlerInterface;
use \Exception;

class QueueListener
{
    private QueueStorageInterface $queueStorage;
    public HandlerInterface $errorHandler;

    public function __construct(QueueStorageInterface $queueStorage, HandlerInterface $errorHandler)
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
                $this->errorHandler->handle($exception);
            }
        }
    }
}