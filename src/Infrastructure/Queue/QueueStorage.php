<?php

namespace App\Infrastructure\Queue;

use App\Application\Commands\CommandInterface;

class QueueStorage implements QueueStorageInterface
{
    public static $queue = [];

    public function take(): ?CommandInterface
    {
        return array_pop(self::$queue);
    }

    public static function push(CommandInterface $command): void
    {
        self::$queue[] = $command;
    }
}