<?php

namespace App\Application\Scope;

interface ScopeInterface
{
    public function resolve(string $key, ...$args): object;
}