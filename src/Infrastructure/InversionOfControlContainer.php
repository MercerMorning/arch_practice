<?php

namespace App\Infrastructure;

use InvalidArgumentException;

class InversionOfControlContainer
{
//    /**
//     * @var $binded Closure[]
//     */
//    protected $binded = [];

    public $strategy;

    public function __construct()
    {
        $this->strategy = function ($key, array $arguments) {
            if ($key == 'IoC.SetupStrategy') {
                return new SetupStrategyCommand($arguments[0]);
            } elseif ($key == 'IoC.Default') {
                return $this->defaultStrategy();
            } else {
                throw new InvalidArgumentException('Unknown IoC dependency');
            }
        };
//        $this->binded['IoC.Register'] = function (array $args) {
//            $this->binded[$args[0]] = $args[1];
//        };
    }

    public function resolve(string $key, ...$args)
    {
        return $this->strategy($key, $args);
//        if (isset($this->binded[$key])) {
//            return $this->binded[$key]($args);
//        }
    }

    private function strategy(string $key, array $args)
    {
        return $this->strategy($key, $args);
    }

    private function defaultStrategy()
    {
        return function () {

        };
    }


}