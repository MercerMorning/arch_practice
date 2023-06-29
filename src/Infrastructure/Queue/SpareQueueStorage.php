<?php

namespace App\Infrastructure\Queue;

use App\Application\Commands\CommandInterface;

class SpareQueueStorage implements QueueStorageInterface
{
    public static $queue = [];
    public static $isActive = true;

    public static function push(CommandInterface $command): void
    {
        self::$queue[] = $command;
    }

    public static function unshift(CommandInterface $command): void
    {
        array_unshift(self::$queue, $command);
    }

    public function take(): ?CommandInterface
    {
        if (self::$isActive) {
            return array_shift(self::$queue);
        }
        return null;
    }
}