<?php

namespace App\Infrastructure\Queue\Statements;

use App\Application\Commands\MoveToCommand;
use App\Application\Commands\QueueStopCommand;
use App\Application\Commands\RunCommand;
use App\Infrastructure\Exceptions\ExceptionHandlerInterface;
use App\Infrastructure\Queue\QueueStorageInterface;
use App\Infrastructure\Queue\SpareQueueStorage;
use \Exception;

class MoveTo implements StatementInterface
{
    const COMMAND_STATEMENTS = [
        QueueStopCommand::class => Finished::class,
        RunCommand::class => Common::class
    ];

    public function handle(
        QueueStorageInterface $queueStorage,
        ExceptionHandlerInterface $exceptionHandler
    ): StatementInterface|null
    {
        $queueItem = $queueStorage->take();
        if ($queueItem) {
            SpareQueueStorage::push($queueItem);
            $statement = self::COMMAND_STATEMENTS[$queueItem::class] ?? null;
            if ($statement) {
                return new $statement();
            }
            return $this;
        }
        return null;
    }
}