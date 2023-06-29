<?php

namespace App\Application\Commands;

use App\Infrastructure\Queue\QueueStorage;

class SoftQueueStopCommand implements CommandInterface
{
    public function execute()
    {
        QueueStorage::push(new ForceQueueStopCommand());
    }
}