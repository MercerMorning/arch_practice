<?php

namespace App\Infrastructure;

use Closure;

class RegisterIoCDependencyCommand
{
    private string $key;
    private Closure $strategy;
    private ScopeInterface $scope;

    /**
     * @param string $key
     * @param Closure $strategy
     */
    public function __construct(ScopeInterface $scope, string $key, Closure $strategy)
    {
        $this->scope = $scope;
        $this->key = $key;
        $this->strategy = $strategy;
    }

    public function execute()
    {
        var_dump($this->scope->dependencies);
        $this->scope->dependencies[$this->key] = $this->strategy;
    }
}