<?php

namespace App\Infrastructure;

class ScopeBasedResolveDependencyStrategy
{
    public static ScopeInterface $root;

    public static ScopeInterface $defaultScope;

    public function __construct()
    {
        self::$defaultScope = new RootScope();
    }

    public static function currentScope()
    {
        if (isset(self::$defaultScope)) {
            return self::$defaultScope;
        }
        if (!self::$root) {
            self::$root = new RootScope();
        }
        return self::$root;
    }

    public static function resolve(string $key, array $arguments = [])
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

    public static function strategy()
    {
        return function (string $key, array $arguments) {
            return self::resolve($key, $arguments);
        };
    }
}