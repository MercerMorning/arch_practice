<?php

namespace App\Application\Commands;

use App\Infrastructure\Queue\QueueStorage;

class AddSoftQueueStopCommandToQueue implements CommandInterface
{
    public function execute()
    {
        QueueStorage::push(new QueueStopCommand());
    }
}