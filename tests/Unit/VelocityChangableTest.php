<?php

namespace Tests\Unit;

use App\Application\Commands\ChangeVelocity;
use App\Domain\Coordinate;
use App\Domain\VelocityChangableInterface;
use PHPUnit\Framework\TestCase;

class ChangeVelocityTest extends TestCase
{
    public function testChangeVelocity()
    {
        $stub = $this->createMock(VelocityChangableInterface::class);
        $stub->method('getVelocity')
            ->willReturn(new Coordinate(7, 5));
        $stub->method('getAngle')
            ->willReturn(1.5);

        $changeVelocityCommand = new ChangeVelocity($stub);
        $changeVelocityCommand->execute();

        $this->assertEquals(new Coordinate(1, 9), $stub->getVelocity());
    }

}