<?php

declare(strict_types=1);

namespace App\Application\Commands;

use App\Infrastructure\Queue\QueueStorageInterface;

class RepeatCommand implements CommandInterface
{
    private CommandInterface $command;
    private QueueStorageInterface $queue;

    public function __construct(QueueStorageInterface $queue, CommandInterface $command)
    {
        $this->queue   = $queue;
        $this->command = $command;
    }

    public function execute()
    {
        // запись в лог
        $this->queue->push($this->command);
    }
}