<?php

namespace App\Infrastructure\Queue\Statements;

use App\Application\Commands\MoveToCommand;
use App\Application\Commands\QueueStopCommand;
use App\Infrastructure\Exceptions\ExceptionHandlerInterface;
use App\Infrastructure\Queue\QueueStorageInterface;
use \Exception;

class Common implements StatementInterface
{
    const COMMAND_STATEMENTS = [
        QueueStopCommand::class => Finished::class,
        MoveToCommand::class => MoveTo::class
    ];

    public function __construct()
    {

    }
    public function handle(
        QueueStorageInterface $queueStorage,
        ExceptionHandlerInterface $exceptionHandler
    ): StatementInterface|null
    {
        $queueItem = $queueStorage->take();
        if ($queueItem) {
            try {
                $queueItem->execute();
            } catch (Exception $exception) {
                $exceptionHandler->handle($queueItem, $exception);
            }
            $statement = self::COMMAND_STATEMENTS[$queueItem::class] ?? null;
            if ($statement) {
                return new $statement();
            }
            return $this;
        }
        return null;
    }
}