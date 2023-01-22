<?php

declare(strict_types=1);

namespace App\Application\Commands;

use App\Infrastructure\InversionOfControlContainer;

class SetupStrategyCommand implements CommandInterface
{
    private object $newStrategy;

    public function __construct(object $newStrategy)
    {
        $this->newStrategy = $newStrategy;
    }

    public function execute()
    {
        InversionOfControlContainer::$strategy = $this->newStrategy;
    }
}