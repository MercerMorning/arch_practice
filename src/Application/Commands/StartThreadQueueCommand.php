<?php

namespace App\Application\Commands;

use App\Infrastructure\InversionOfControlContainer;
use App\Infrastructure\Queue\QueueListener;

class StartThreadQueueCommand implements CommandInterface
{
    public function execute()
    {
        $queueListener = InversionOfControlContainer::resolve(QueueListener::class);

    }
}