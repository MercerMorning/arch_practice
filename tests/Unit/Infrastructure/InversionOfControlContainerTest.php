<?php

namespace Tests\Unit\Infrastructure;


use App\Infrastructure\InitScopeBasedIoCImplementation;
use App\Infrastructure\InversionOfControlContainer;
use PHPUnit\Framework\TestCase;

class InversionOfControlContainerTest extends TestCase
{
    public function testResolve()
    {
        $command = new InitScopeBasedIoCImplementation();
        $command->execute();
        $container = new InversionOfControlContainer();
        var_dump(InversionOfControlContainer::resolve('IoC.Default'));
        exit();
//       $result = $container->resolve( 'IoC.Default');
//        $container->resolve( 'IoC.SetupStrategy', function (...$arguments) {
//           echo 'newStrategy';
//       })->execute();
        $container->resolve('IoC.Default', function (...$arguments) {
            echo 'newStrategy';
        });
        ($container->strategy)();
        exit();
//       $container->resolve('IoC.Register', 'A', function (array $args){
//            return $args[0];
//       });
//       $result = $container->resolve('A', 'test');
//       $this->assertSame('test', $result);
    }
}