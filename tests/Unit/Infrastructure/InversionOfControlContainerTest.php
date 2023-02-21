<?php

namespace Tests\Unit\Infrastructure;


use App\Infrastructure\InversionOfControlContainer;
use PHPUnit\Framework\TestCase;

class InversionOfControlContainerTest  extends TestCase
{
    public function testResolve()
    {
       $container = new InversionOfControlContainer();
       $container->resolve('IoC.Register', 'A', function (array $args){
            return $args[0];
       });
       $result = $container->resolve('A', 'test');
       $this->assertSame('test', $result);
    }
}