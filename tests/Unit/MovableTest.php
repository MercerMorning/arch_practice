<?php

namespace Tests\Unit;

use App\Application\Commands\Move;
use App\Domain\Coordinate;
use App\Domain\MovableInterface;
use PHPUnit\Framework\TestCase;
use Throwable;

class MovableTest extends TestCase
{
    public function testChangePosition()
    {
        $stub = $this->createMock(MovableInterface::class);
        $stub->method('getVelocity')
            ->willReturn(new Coordinate(-7, 3));
        $stub->method('getPosition')
            ->will($this->onConsecutiveCalls(
                new Coordinate(12, 5),
                new Coordinate(5, 8))
            );
        $moveCommand = new Move($stub);
        $moveCommand->execute();

        $this->assertEquals(new Coordinate(5, 8), $stub->getPosition());
    }

    public function testChangePositionWithObjectWithoutGetPositionAbility()
    {
        $this->expectException(Throwable::class);
        $moveCommand = new Move(null);
        $moveCommand->execute();
    }

    public function testChangePositionWithObjectWithoutGetVelocityAbility()
    {
        $this->expectException(Throwable::class);
        $moveCommand = new Move(null);
        $moveCommand->execute();
    }

    public function testChangePositionWithObjectWithoutSetPositionAbility()
    {
        $this->expectException(Throwable::class);
        $moveCommand = new Move(null);
        $moveCommand->execute();
    }
}