<?php

namespace Tests\Unit\Infrastructure;


use App\Infrastructure\InitScopeBasedIoCImplementation;
use App\Infrastructure\InversionOfControlContainer;
use PHPUnit\Framework\TestCase;

class InversionOfControlContainerTest extends TestCase
{
    public function testResolve()
    {

        $container = new InversionOfControlContainer();
        $container::resolve( 'IoC.Default');
        $command = new InitScopeBasedIoCImplementation();
        $command->execute();

        $scope = $container::resolve('Scopes.Current');
        $scope->resolve("IoC.Register", 'testQuery', function () {
            return 'test';
        });
        var_dump($scope->resolve('testQuery'));
        exit();
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