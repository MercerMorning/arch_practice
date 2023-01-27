<?php

namespace Tests\Unit\Infrastructure;


use App\Infrastructure\InitScopeBasedIoCImplementation;
use App\Infrastructure\InversionOfControlContainer;
use App\Infrastructure\LeafScope;
use App\Infrastructure\Scope;
use PHPUnit\Framework\TestCase;

class InversionOfControlContainerTest extends TestCase
{
    public function testResolve()
    {

        $container = new InversionOfControlContainer();
        $command = new InitScopeBasedIoCImplementation();
        $command->execute();

        $scope = new Scope([], new LeafScope(function () { }));

        $container->resolve("Scopes.New", '1', $scope);
        var_dump($container->resolve("Scopes.Storage"));

exit();
        $container->resolve("IoC.Register", 'testQuery', function () {
            return 'test';
        })->execute();

//        var_dump(array_keys($container->resolve('Scopes.Current')->dependencies));
//        exit();
        var_dump($container->resolve("testQuery"));
////        var_dump($scope);
        exit();
    }

//    public function testResolve()
//    {
//
//        $container = new InversionOfControlContainer();
////        $container::resolve( 'IoC.Default');
//        $command = new InitScopeBasedIoCImplementation();
//        $command->execute();
//
//        $scope = $container::resolve('');
//
//        $registerCommand = $scope->resolve("IoC.Register", 'testQuery', function () {
//            return 'test';
//        });
//
//        $registerCommand->execute();
//        var_dump($scope->resolve('testQuery'));
//        exit();
//    }
}