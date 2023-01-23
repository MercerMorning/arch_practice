<?php

namespace App\Infrastructure;

class Scope implements ScopeInterface
{
    /*
     * IocRegister, Movement
     */
    public array $dependencies;
    private ScopeInterface $parent;

    /**
     * @param array $dependencies
     * @param ScopeInterface $parent
     */
    public function __construct(array $dependencies, ScopeInterface $parent)
    {
        $this->dependencies = $dependencies;
        $this->parent = $parent;
    }


    public function resolve(string $key, array $arguments)
    {
        if (isset($this->dependencies[$key])) {
            return $this->dependencies[$key]($arguments);
        } else {
            return $this->parent->resolve($key, $arguments);
        }
    }
}