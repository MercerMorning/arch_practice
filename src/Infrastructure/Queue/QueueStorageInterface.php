<?php

namespace App\Infrastructure\Queue;

use App\Application\Commands\CommandInterface;

interface QueueStorageInterface
{
    public function take(): ?CommandInterface;
}