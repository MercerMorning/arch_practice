<?php

namespace App\Infrastructure;

use Closure;
use InvalidArgumentException;

class InversionOfControlContainer
{
    public Closure $strategy;
    private static self $instance;

    public function __construct()
    {
        $this->strategy = function ($key, array $arguments) {
            if ($key == 'IoC.SetupStrategy') {
                return new SetupStrategyCommand($this, $arguments[0]);
            } elseif ($key == 'IoC.Default') {
                return $this->defaultStrategy();
            } else {
                throw new InvalidArgumentException('Unknown IoC dependency');
            }
        };
    }

    public function resolve(string $key, ...$args)
    {
        $strategy = $this->strategy;
        return $strategy($key, $args);
    }

    private function defaultStrategy()
    {
        return function () {
            echo 'defaultStrategy';
        };
    }

    public static function getInstance()
    {
        return self::$instance;
    }

    public static function setInstance(self $container)
    {
        self::$instance = $container;
    }
}