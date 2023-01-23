<?php

namespace App\Infrastructure;

use Closure;

class SetupStrategyCommand
{
    private InversionOfControlContainer $container;
    private Closure $newStrategy;

    public function __construct(InversionOfControlContainer $container, Closure $newStrategy)
    {
        $this->container = $container;
        $this->newStrategy = $newStrategy;
    }

    public function execute()
    {
        $this->container::$strategy = $this->newStrategy;
    }
}