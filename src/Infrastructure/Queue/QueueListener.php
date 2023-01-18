<?php

namespace App\Infrastructure\Queue;

use App\Infrastructure\Exceptions\CommandHandlerInterface;
use \Exception;

class QueueListener
{
    private QueueStorageInterface $queueStorage;
    public CommandHandlerInterface $errorHandler;

    public function __construct(QueueStorageInterface $queueStorage, CommandHandlerInterface $errorHandler)
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
                $this->errorHandler->handle($queueItem::class, $exception);
            }
        }
    }
}