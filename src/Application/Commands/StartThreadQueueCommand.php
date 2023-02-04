<?php

namespace App\Application\Commands;

use App\Infrastructure\Exceptions\ExceptionHandlerInterface;
use App\Infrastructure\InversionOfControlContainer;
use App\Infrastructure\Queue\QueueStorageInterface;
use Exception;

class StartThreadQueueCommand implements CommandInterface
{
    private QueueStorageInterface $queueStorage;
    public ExceptionHandlerInterface $errorHandler;

    public function __construct()
    {
        $this->queueStorage = InversionOfControlContainer::getInstance()->resolve(QueueStorageInterface::class);
        $this->errorHandler = InversionOfControlContainer::getInstance()->resolve(ExceptionHandlerInterface::class);
    }

    public function execute(): void
    {
        while ($queueItem = $this->queueStorage->take()) {
            try {
                $queueItem->execute();
            } catch (Exception $exception) {

            }
        }
    }
}