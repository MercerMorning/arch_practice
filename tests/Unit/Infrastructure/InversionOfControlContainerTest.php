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
//        $container::resolve( 'IoC.Default');
        $command = new InitScopeBasedIoCImplementation();
        $command->execute();


        $scope = $container::resolve('Scopes.Storagee', '');

//        $registerCommand = $scope->resolve("IoC.Register", 'testQuery', function () {
//            return 'test';
//        });

//        $registerCommand->execute();
        var_dump($scope);
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