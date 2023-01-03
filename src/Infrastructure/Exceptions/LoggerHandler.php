<?php

namespace App\Infrastructure\Exceptions;

use App\Application\Commands\Log;
use App\Infrastructure\Queue\QueueStorageInterface;
use Throwable;

/**
 * Обработчик исключений для логирования
 */
class LoggerHandler implements HandlerInterface
{
    private QueueStorageInterface $queueStorage;

    /**
     * @param QueueStorageInterface $queueStorage
     */
    public function __construct(QueueStorageInterface $queueStorage)
    {
        $this->queueStorage = $queueStorage;
    }

    public function handle(Throwable $exception)
    {
        $logCommand = new Log($exception);
        $this->queueStorage->push($logCommand);
    }
}