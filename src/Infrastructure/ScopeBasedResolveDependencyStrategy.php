<?php

namespace App\Infrastructure;

class ScopeBasedResolveDependencyStrategy
{
    public static ScopeInterface $root;

    public static $defaultScope;

    public function __construct()
    {
        self::$defaultScope = new RootScope();
    }

    public static function currentScope()
    {
        if (!self::$defaultScope) {
            self::$defaultScope = new RootScope();
        }
        return self::$defaultScope;
//       if ($scope = InversionOfControlContainer::resolve('Scopes.Current')) {
//           return $scope;
//       }
//        return new RootScope();
    }

    public function resolve(string $key, array $arguments)
    {
        if ($key == "Scopes.Root"){
            return new RootScope();
        } else {
            $scope = self::currentScope();

            if ($scope == null) {
                $scope = new DefaultScope();
            }

            return $scope->resolve($key, $arguments);
        }
    }
}