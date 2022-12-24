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
                new Coordinate(4, 8),
                new Coordinate(6, 12)
            ));

        $changeVelocityCommand = new ChangeVelocity($stub, 1.5);
        $changeVelocityCommand->execute();

        $this->assertEquals(new Coordinate(6, 12), $stub->getVelocity());
    }

    public function testChangeVelocityWithoutVelocityAvaiable()
    {
        $this->expectException(Throwable::class);
        $changeVelocityCommand = new ChangeVelocity(null);
        $changeVelocityCommand->execute();
    }      

}