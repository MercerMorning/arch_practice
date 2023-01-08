<?php

declare(strict_types=1);

namespace App\Infrastructure\Exceptions;

use App\Application\Commands\CommandInterface;
use App\Application\Commands\RepeatCommand;
use App\Infrastructure\Queue\QueueStorageInterface;
use Throwable;

class CommandExceptionHandler implements ExceptionHandlerInterface
{
    private QueueStorageInterface $queueStorage;

    public function __construct(QueueStorageInterface $queueStorage)
    {
        $this->queueStorage = $queueStorage;
    }

    public function handle(CommandInterface $command, Throwable $exception): void
    {
        $repeatCommand = new RepeatCommand($this->queueStorage, $command);
        $repeatCommand->execute();
    }
}