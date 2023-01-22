<?php

namespace App\Application\Scope;

class LeafScope implements ScopeInterface
{
    public object $strategy;

    public function __construct(object $strategy)
    {
        $this->strategy = $strategy;
    }

    public function resolve(string $key, ...$args): object
    {
        return $this->strategy($key, $args);
    }
}