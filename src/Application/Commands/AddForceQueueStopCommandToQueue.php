<?php

namespace App\Application\Commands;

use App\Infrastructure\Queue\QueueStorage;

class AddForceQueueStopCommandToQueue implements CommandInterface
{
    public function execute()
    {
        QueueStorage::unshift(new QueueStopCommand());
    }
}