<?php

namespace App\Infrastructure;

class LeafScope implements ScopeInterface
{
    private \Closure $strategy;
    /**
     * @param \Closure $strategy
     */
    public function __construct(\Closure $strategy)
    {
        $this->strategy = $strategy;
    }

    public function resolve(string $key, array $arguments)
    {
        return ($this->strategy)($key, $arguments);
    }
}