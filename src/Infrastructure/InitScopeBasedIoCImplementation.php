<?php

namespace App\Infrastructure;

class InitScopeBasedIoCImplementation
{
    public function execute()
    {
        // Защита от повторного вызова
        if (isset(ScopeBasedResolveDependencyStrategy::$root)) {
            return;
        }

        $dependencies = [];

        $storage = [];
        $dependencies['Scopes.Storage'] = function () use ($storage){
            return $storage;
        };
        $dependencies['Scopes.New'] = function (array $arguments) use (&$storage){
            $storage[$arguments[0]] = $arguments[1];
        };

        $dependencies['Scopes.Current'] = function () {
            $scope = ScopeBasedResolveDependencyStrategy::currentScope();
            if ($scope !== null) {
                return $scope;
            } else {
                return ScopeBasedResolveDependencyStrategy::$defaultScope;
            }
        };

        $dependencies['IoC.Register'] = function (array $arguments = []) {;
            return new RegisterIoCDependencyCommand($arguments[0], $arguments[1]);
        };

        $scope = new Scope($dependencies, new LeafScope(InversionOfControlContainer::resolve('IoC.Default')));

        ScopeBasedResolveDependencyStrategy::$root = $scope;

        InversionOfControlContainer::resolve(
            'IoC.SetupStrategy',
            ScopeBasedResolveDependencyStrategy::strategy()
        )->execute();
        //set scope in current
    }
}