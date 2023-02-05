<?php

namespace App\Application\Commands;

use App\Infrastructure\Queue\QueueStorage;

class QueueStopCommand implements CommandInterface
{
    public function execute()
    {
        QueueStorage::$queue = [];
    }
}