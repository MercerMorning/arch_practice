<?php

namespace App\Infrastructure\Queue;

use App\Application\Commands\CommandInterface;

interface QueueStorageInterface
{
    public function take(): ?CommandInterface;

    public static function push(CommandInterface $command): void;

    public static function unshift(CommandInterface $command): void;
}