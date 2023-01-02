<?php

namespace App\Infrastructure\Queue;

class QueueListener
{
    public QueueStorageInterface $queueStorage;

    public function __construct(QueueStorageInterface $queueStorage)
    {
        $this->queueStorage = $queueStorage;
    }

    public function listen(): void
    {
        while ($queueItem = $this->queueStorage->take()) {
            $queueItem->execute();
        }
    }
}