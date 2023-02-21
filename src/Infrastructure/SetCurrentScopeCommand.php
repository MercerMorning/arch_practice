<?php

namespace App\Infrastructure;

use Closure;

class SetCurrentScopeCommand
{
    private string $key;

    /**
     * @param string $key
     */
    public function __construct(string $key)
    {
        $this->key = $key;
    }

    public function execute()
    {
        $storage = InversionOfControlContainer::resolve('Scopes.Storage');

        $scope = $storage[$this->key];
        $scope->dependencties['Scopes.Storage'] = function () use ($storage){
            return $storage;
        };
        ScopeBasedResolveDependencyStrategy::$defaultScope = $scope;
        ScopeBasedResolveDependencyStrategy::currentScope()->dependencies['Scopes.Storage'] = function () use ($storage){
            return $storage;
        };

    }
}