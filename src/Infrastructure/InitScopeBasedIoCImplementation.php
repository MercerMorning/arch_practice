<?php

namespace App\Infrastructure;

class InitScopeBasedIoCImplementation
{
    public function execute()
    {
        if (ScopeBasedResolveDependencyStrategy::$root !== null) {
            return;
        }

        $dependencies = [];

        $scope = new Scope($dependencies, new LeafScope('Ioc.Default'));

        $dependencies['Scopes.Strategy'] = function (array $arguments) {
            return [];
        };
        $dependencies['Scopes.New'] = function (array $arguments) {
            new Scope(
                InversionOfControlContainer::resolve('Scopes.Strategy')
                , $arguments[0]);
        };
        $dependencies['Scopes.Current'] = function (array $arguments) {
            $scope = ScopeBasedResolveDependencyStrategy::currentScope();
            if ($scope !== null){
                return $scope;
            } else {
                return ScopeBasedResolveDependencyStrategy::$defaultScope;
            }
        };
        $dependencies['IoC.Register'] = function (array $arguments) {
            return new RegisterIoCDependencyCommand($arguments[0]);
        };
    }
}