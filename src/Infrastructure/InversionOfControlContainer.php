<?php

namespace App\Infrastructure;

use Closure;

class InversionOfControlContainer
{
    /**
     * @var $binded Closure[]
     */
    protected $binded = [];

    public function __construct()
    {
        $this->binded['IoC.Register'] = function (array $args) {
            $this->binded[$args[0]] = $args[1];
        };
    }

    public function resolve(string $key, ...$args)
    {
        if (isset($this->binded[$key])) {
            return $this->binded[$key]($args);
        }
    }
}