<?php

namespace App\Application\Scope;

class Scope implements ScopeInterface
{
    private $dependencies;

    private ScopeInterface $parent;

    public function __construct($dictionary, $dependencies, ScopeInterface $parent)
    {
        $this->dependencies = $dependencies;
        $this->parent = $parent;
    }

    public function resolve(string $key, ...$args): object
    {
        if ($dependencies->tryGetValues($key, function () {return dependencyResolver; })) {
            return dependencyResolver($args);
        } else {
            return $this->parent->resolve($key, $args);
        }
    }
}