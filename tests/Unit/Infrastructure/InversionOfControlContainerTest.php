<?php

namespace Tests\Unit\Infrastructure;


use App\Domain\TankOperationsMovableInterface;
use App\Infrastructure\IoC;
use PHPUnit\Framework\TestCase;

class InversionOfControlContainerTest  extends TestCase
{
    public function testResolve()
    {
       $container = new IoC();
       $container->resolve('IoC.Register', 'A', function (array $args){
            return $args[0];
       });
       $result = $container->resolve('A', 'test');
       $this->assertSame('test', $result);
    }

    public function testAutoGenerating()
    {
        $container = new IoC();
        $container->generate(TankOperationsMovableInterface::class);
    }
}