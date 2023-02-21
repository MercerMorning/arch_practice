<?php

namespace App\Infrastructure;

use Closure;

class RegisterNewScopeCommand
{
    private string $key;
    private ScopeInterface $scope;

    /**
     * @param string $key
     * @param Closure $strategy
     */
    public function __construct(string $key, ScopeInterface $scope)
    {
        $this->key = $key;
        $this->scope = $scope;
    }

    public function execute()
    {
        $storage = InversionOfControlContainer::resolve('Scopes.Storage');

        ScopeBasedResolveDependencyStrategy::currentScope()->dependencies['Scopes.Storage'] = function () use ($storage){
            $storage[$this->key] = $this->scope;
            return $storage;
        };
    }
}