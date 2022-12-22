<?php

namespace Tests\Unit;

use App\Application\Commands\ChangeVelocity;
use App\Domain\Coordinate;
use App\Domain\VelocityChangableInterface;
use PHPUnit\Framework\TestCase;
use Throwable;

class ChangeVelocityTest extends TestCase
{
    public function testChangeVelocity()
    {
        $stub = $this->createMock(VelocityChangableInterface::class);
        $stub->method('getVelocity')
            ->will($this->onConsecutiveCalls(
                new Coordinate(7, 5),
                new Coordinate(1, 9)
            ));
        $stub->method('getAngle')
            ->willReturn(1.5);

        $changeVelocityCommand = new ChangeVelocity($stub);
        $changeVelocityCommand->execute();

        $this->assertEquals(new Coordinate(1, 9), $stub->getVelocity());
    }

    public function testChangeVelocityWithoutAngleAviable()
    {
        $this->expectException(Throwable::class);
        $changeVelocityCommand = new ChangeVelocity(null);
        $changeVelocityCommand->execute();
    }

    public function testChangeVelocityWithoutVelocityAvaiable()
    {
        $this->expectException(Throwable::class);
        $changeVelocityCommand = new ChangeVelocity(null);
        $changeVelocityCommand->execute();
    }      

}