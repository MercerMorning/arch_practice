<?php

namespace App\Application\Commands;

use App\Infrastructure\InversionOfControlContainer;
use App\Infrastructure\Queue\QueueListener;
use App\Infrastructure\Queue\QueueStorage;
use App\Infrastructure\Queue\QueueStorageInterface;

class QueueStopCommand implements CommandInterface
{
    public function execute()
    {
        QueueStorage::$queue = [];
    }
}