<?php

namespace App\Application\Scope;

class ScopeBasedResolveDependencyStrategy
{
    static Scope $root;

    private static function currentScopes(): \Threaded
    {
        return new \Threaded();
    }

    public static function resolve(string $key, ...$args)
    {
        if($key === "Scopes.Root") {
            return self::$root;
        } else {
            // @TODO
        }
    }
}