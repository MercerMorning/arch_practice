<?php

namespace App\Infrastructure;

use App\Application\Commands\SetupStrategyCommand;
use Closure;
use Exception;

class InversionOfControlContainer
{
    /**
     * @var $binded Closure[]
     */
    protected $binded = [];

    public static object $strategy;

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

    /**
     * @throws Exception
     */
    private static function DefaultStrategy(string $key, ...$args): object
    {
        if ("IoC.SetupStrategy" === $key) {
            return new SetupStrategyCommand($args[0]);
        } elseif ("IoC.Default" === $key) {
            return self::DefaultStrategy($key, $args);
        } else {
            throw new Exception("Неизвестный ключ IoC зависимости $key");
        }
    }
}