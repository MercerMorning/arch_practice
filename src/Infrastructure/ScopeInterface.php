<?php

namespace App\Infrastructure;

interface ScopeInterface
{
    public function resolve(string $key, array $arguments);
}