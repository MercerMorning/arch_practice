<?php

namespace App\Infrastructure\Queue;

use App\Application\Commands\CommandInterface;

class QueueStorage implements QueueStorageInterface
{
    public static $queue = [];
    private $isActive = true;

    public function take(): ?CommandInterface
    {
        if ($this->isActive) {
            return array_pop(self::$queue);
        }
    }

    public static function push(CommandInterface $command): void
    {
        self::$queue[] = $command;
    }
}