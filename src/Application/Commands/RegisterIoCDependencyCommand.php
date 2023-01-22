<?php

namespace App\Application\Commands;

use App\Application\Scope\ScopeBasedResolveDependencyStrategy;

class RegisterIoCDependencyCommand implements CommandInterface
{
    private string $key;
    private object $strategy;

    public function __construct(string $key, object $strategy)
    {
        $this->key = $key;
        $this->strategy = $strategy;
    }

    public function execute()
    {
        if (! ScopeBasedResolveDependencyStrategy::resolve($this->key, $this->strategy)) {
            throw new \Exception("Не удалось зарегистрировать зависимость");
        }
    }
}