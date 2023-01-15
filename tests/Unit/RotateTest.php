<?php

namespace Tests\Unit;

use App\Application\Commands\Rotate;
use App\Domain\RotateCoordinate;
use App\Domain\RotateInterface;
use PHPUnit\Framework\TestCase;

class RotateTest extends TestCase
{
    public function testRotateObject()
    {
        $stub = $this->createMock(RotateInterface::class);
        $stub->method('getAngularVelocity')
            ->willReturn(new RotateCoordinate(7, 3));
        $stub->method('getAngular')
            ->will($this->onConsecutiveCalls(
                new RotateCoordinate(10, 5),
                new RotateCoordinate(4, 9))
            );
        $moveCommand = new Rotate($stub);
        $moveCommand->execute();

        $this->assertEquals(new RotateCoordinate(4, 9), $stub->getAngular());
    }
}