<?php

namespace Tests\Unit\Infrastructure;


use App\Infrastructure\InitScopeBasedIoCImplementation;
use App\Infrastructure\InversionOfControlContainer;
use App\Infrastructure\ScopeBasedResolveDependencyStrategy;
use PHPUnit\Framework\TestCase;

class InversionOfControlContainerTest extends TestCase
{
    public function testChangingScopes()
    {
        $container = new InversionOfControlContainer();
        InversionOfControlContainer::setInstance($container);
        $command = new InitScopeBasedIoCImplementation($container);
        $command->execute();

        $scope = clone ScopeBasedResolveDependencyStrategy::$root;

        $container->resolve("IoC.Register", 'scopeTest', function () {
            return 'test';
        })->execute();

        $this->assertSame('test', $container->resolve("scopeTest"));
        $container->resolve("Scopes.New", '1', $scope)->execute();
        $container->resolve("Scopes.Current.Set", '1')->execute();
        $container->resolve("IoC.Register", 'scopeTest', function () {
            return 'test2';
        })->execute();
        $this->assertSame('test2', $container->resolve("scopeTest"));
        $container->resolve("Scopes.Current.Set", 'default')->execute();
        $this->assertSame('test', $container->resolve("scopeTest"));
    }
}