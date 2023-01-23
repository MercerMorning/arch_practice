<?php

namespace App\Infrastructure;

use Closure;
use InvalidArgumentException;

class InversionOfControlContainer
{
    public static Closure $strategy;

    public function __construct()
    {
        self::$strategy = function ($key, array $arguments) {
            if ($key == 'IoC.SetupStrategy') {
                return new SetupStrategyCommand($this, $arguments[0]);
            } elseif ($key == 'IoC.Default') {
                return $this->defaultStrategy();
            } else {
                throw new InvalidArgumentException('Unknown IoC dependency');
            }
        };
    }

    public static function resolve(string $key, ...$args)
    {
        $strategy = self::$strategy;
        return $strategy($key, $args);
    }

    private function defaultStrategy()
    {
        return function () {
            echo 'defaultStrategy';
        };
    }


}