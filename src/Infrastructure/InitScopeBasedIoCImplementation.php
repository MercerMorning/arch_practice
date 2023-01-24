<?php

namespace App\Infrastructure;

class InitScopeBasedIoCImplementation
{
    public function execute()
    {
//        if (ScopeBasedResolveDependencyStrategy::$root !== null) {
//            return;
//        }

        $dependencies = [];

//        $dependencies['Scopes.Storage'] = function (array $arguments) {
//            return [];
//        };
//        $dependencies['Scopes.New'] = function (array $arguments) {
//            new Scope(
//                InversionOfControlContainer::resolve('Scopes.Strategy')
//                , $arguments[0]);
//        };

//        $dependencies['Scopes.Current'] = function () use ($defaultScope) {
//            return $defaultScope;
//            $scope = ScopeBasedResolveDependencyStrategy::currentScope();
//            if ($scope !== null) {
//                return $scope;
//            } else {
//                return ScopeBasedResolveDependencyStrategy::$defaultScope;
//            }
//        };
        $scope = new Scope([], new LeafScope(InversionOfControlContainer::resolve('IoC.Default')));
        $scope->dependencies['IoC.Register'] = function (array $arguments) use ($scope){
            return new RegisterIoCDependencyCommand($scope, $arguments[0], $arguments[1]);
        };


        InversionOfControlContainer::resolve('IoC.SetupStrategy', function () use ($scope) {
            return $scope;
        })->execute();
    }
}