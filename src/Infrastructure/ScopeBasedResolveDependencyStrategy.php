<?php

namespace App\Infrastructure;

class ScopeBasedResolveDependencyStrategy
{
    public static ScopeInterface $root;

    public static $defaultScope;

    public static function currentScope()
    {
//        return self::currentScope()
//        else
        return new RootScope();
    }

    public function resolve(string $key, array $arguments)
    {
        if ($key == "Scopes.Root"){
            return new RootScope();
        } else {
            $scope = $this->scope;

            if ($scope == null) {
                $scope = new DefaultScope();
            }

            return $scope->resolve($key, $arguments);
        }
    }
}