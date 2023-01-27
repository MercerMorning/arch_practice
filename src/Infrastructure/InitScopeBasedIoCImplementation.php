<?php

namespace App\Infrastructure;

class InitScopeBasedIoCImplementation
{
    public function execute()
    {
        // Защита от повторного вызова
        if (ScopeBasedResolveDependencyStrategy::$root !== null) {
            return;
        }

        $dependencies = [];

        $dependencies['Scopes.Storage'] = function (array $arguments) {
            return [];
        };
        $dependencies['Scopes.New'] = function (array $arguments) {
            new Scope(
                InversionOfControlContainer::resolve('Scopes.Storage')
                , $arguments[0]);
        };

        $dependencies['Scopes.Current'] = function () {
            $scope = ScopeBasedResolveDependencyStrategy::currentScope();
            if ($scope !== null) {
                return $scope;
            } else {
                return ScopeBasedResolveDependencyStrategy::$defaultScope;
            }
        };

//        $dependencies['Scopes.Current.Set'] = function () {
//            $scope = ScopeBasedResolveDependencyStrategy::currentScope();
//            if ($scope !== null) {
//                return $scope;
//            } else {
//                return ScopeBasedResolveDependencyStrategy::$defaultScope;
//            }
//        };

        $dependencies['IoC.Register'] = function (...$arguments) {
            return new RegisterIoCDependencyCommand($arguments[0], $arguments[1]);
        };

        $scope = new Scope($dependencies, new LeafScope(InversionOfControlContainer::resolve('IoC.Default')));

        ScopeBasedResolveDependencyStrategy::$root = $scope;

        InversionOfControlContainer::resolve('IoC.SetupStrategy', function () use ($scope) {
            return $scope;
        })->execute();

        //set scope in current
    }
}