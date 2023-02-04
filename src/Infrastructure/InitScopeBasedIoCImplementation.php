<?php

namespace App\Infrastructure;

class InitScopeBasedIoCImplementation
{
    public function execute()
    {
        // Защита от повторного вызова
//        if (isset(ScopeBasedResolveDependencyStrategy::$root)) {
//            return;
//        }

        $dependencies = [];

        $dependencies['Scopes.Storage'] = function (){
            return [];
        };
        $dependencies['Scopes.New'] = function (array $arguments){
            return new RegisterNewScopeCommand($arguments[0], $arguments[1]);
        };

        $dependencies['Scopes.Current'] = function () {
            $scope = ScopeBasedResolveDependencyStrategy::currentScope();
            if ($scope !== null) {
                return $scope;
            } else {
                return ScopeBasedResolveDependencyStrategy::$defaultScope;
            }
        };

        $dependencies['Scopes.Current.Set'] = function (array $arguments) {
            return new SetCurrentScopeCommand($arguments[0]);
        };

        $dependencies['IoC.Register'] = function (array $arguments = []) {;
            return new RegisterIoCDependencyCommand($arguments[0], $arguments[1]);
        };

        $scope = new Scope($dependencies, new LeafScope(InversionOfControlContainer::getInstance()->resolve('IoC.Default')));

        ScopeBasedResolveDependencyStrategy::$root = $scope;

        InversionOfControlContainer::getInstance()->resolve(
            'IoC.SetupStrategy',
            ScopeBasedResolveDependencyStrategy::strategy()
        )->execute();
        InversionOfControlContainer::getInstance()->resolve("Scopes.New", 'default', $scope)->execute();
        //set scope in current
    }
}