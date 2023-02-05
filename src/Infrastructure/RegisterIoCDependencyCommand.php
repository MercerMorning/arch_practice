<?php

namespace App\Infrastructure;

use Closure;

class RegisterIoCDependencyCommand
{
    private string $key;
    private Closure $strategy;

    /**
     * @param string $key
     * @param Closure $strategy
     */
    public function __construct(string $key, Closure $strategy)
    {
        $this->key = $key;
        $this->strategy = $strategy;
    }

    public function execute()
    {
        ScopeBasedResolveDependencyStrategy::currentScope()->dependencies[$this->key] = $this->strategy;
    }
}