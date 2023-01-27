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
        var_dump(111);
        exit();
        ScopeBasedResolveDependencyStrategy::$root = $scope;
    }
}