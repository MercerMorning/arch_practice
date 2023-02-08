<?php

namespace App\Infrastructure;

class Route
{
    public static function contentToRender() : void
    {
        $uri = self::processURI();
        if (class_exists($uri['controller'])) {
            $controller = $uri['controller'];
            $method = $uri['method'];
            $args = $uri['args'];
            //Now, the magic
            $args ? $controller::{$method}(...$args) :
                $controller::{$method}();
        }
    }

    private static function getURI() : array
    {
        $path_info = $_SERVER['REQUEST_URI'] ?? '/';
        $path_info = trim($path_info, '/');
        return explode('/', $path_info);
    }

    private static function processURI() : array
    {
        $controllerPart = self::getURI()[0] ?? '';
        $methodPart = self::getURI()[1] ?? '';
        $numParts = count(self::getURI());
        $argsPart = [];
        for ($i = 2; $i < $numParts; $i++) {
            $argsPart[] = self::getURI()[$i] ?? '';
        }

        //Let's create some defaults if the parts are not set
        $controller = !empty($controllerPart) ?
            'App\Infrastructure\Http\Controllers\\'.$controllerPart.'Controller' :
            'App\Infrastructure\Http\Controllers\HomeController';

        $method = !empty($methodPart) ?
            $methodPart :
            'index';

        $args = !empty($argsPart) ?
            $argsPart :
            [];

        return [
            'controller' => $controller,
            'method' => $method,
            'args' => $args
        ];
    }
}