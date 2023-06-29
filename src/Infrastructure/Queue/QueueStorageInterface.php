<?php

namespace App\Infrastructure\Queue;

use App\Application\Commands\CommandInterface;

interface QueueStorageInterface
{
    /**
     * Взять команду из очереди
     *
     * @return CommandInterface|null
     */
    public function take(): ?CommandInterface;

    /**
     * Положить команду в очередь
     *
     * @param CommandInterface $command
     * @return void
     */
    public static function push(CommandInterface $command): void;

    public static function unshift(CommandInterface $command): void;
}