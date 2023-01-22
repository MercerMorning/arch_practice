<?php

namespace App\Infrastructure;

use Closure;
use ReflectionClass;
use ReflectionMethod;
use ReflectionParameter;

class IoC
{
    const GENERATED_PATH = '/Generated/';

    /**
     * @var $binded Closure[]
     */
    public static $binded = [];

    public function __construct()
    {
        self::$binded['IoC.Register'] = function (array $args) {
            self::$binded[$args[0]] = $args[1];
        };
    }


    public function resolve(string $key, ...$args)
    {
        if (isset(self::$binded[$key])) {
            return self::$binded[$key]($args);
        }
    }

    public function generate(string $class)
    {
        $ref = new ReflectionClass($class);
        $interfaceName = array_reverse(explode("\\", $class))[0];
        $className = 'AutoGenerated' . $interfaceName . 'Adapter';
        $class =
            '<?php ' . PHP_EOL . 'class ' . $className . ' implements \\' . $class;
        $body = '';
        $body .=
            'private \\' . IoC::class . ' $container;' . PHP_EOL .
            'private object $object;' . PHP_EOL .
            'public function __construct(object $object) {
                $this->object = $object;
                $this->container = new ' . IoC::class . '();
            }';
        /**
         * @var $methods ReflectionMethod[]
         */
        $methods = $ref->getMethods();
        foreach ($methods as $method) {

            $methodArguments = [];
            $containerArguments = [];
            if ($method->getParameters()) {
                foreach ($method->getParameters() as $methodParameter) {
                    $methodArguments[] = "\\" . $methodParameter->getType() . ' $' . $methodParameter->getName();
                    $containerArguments[] = '$' . $methodParameter->getName();
                }
            }
            $methodArguments = implode(', ', $methodArguments);
            $containerArguments = implode(',', $containerArguments);

            $methodName = $method->getName();
            $methodReturnType = $method->getReturnType()?->getName();


            $methodBody = PHP_EOL . "public function {$methodName} ({$methodArguments})";
            if ($methodReturnType) {
                $methodBody .= ": \\{$methodReturnType}";
            }


            $methodBody .= "{ return \$this->container->resolve('{$interfaceName}.{$methodName}', \$this->object";
            if ($methodArguments) {
                $methodBody .= ',' . $containerArguments;
            }
            $methodBody .= "); }";

            $body .= $methodBody . PHP_EOL;
        }
        $class .= PHP_EOL . '{' . $body . '}';
        $path = __DIR__ . self::GENERATED_PATH . $className . '.php';
        file_put_contents($path, $class);
        require_once $path;
    }

}
