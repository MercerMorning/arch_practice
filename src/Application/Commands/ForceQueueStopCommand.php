<?php

namespace App\Application\Commands;

use App\Infrastructure\Queue\QueueStorage;

class ForceQueueStopCommand implements CommandInterface
{
    public function execute()
    {
        QueueStorage::$isActive = false;
        QueueStorage::$queue = [];
    }
}