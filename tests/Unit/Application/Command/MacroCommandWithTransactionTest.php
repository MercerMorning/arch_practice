<?php

namespace Tests\Unit\Application\Command;

use App\Application\Commands\CommandInterface;
use App\Application\Commands\MacroCommandThrowingSourceException;
use App\Application\Commands\MacroCommandWithTransaction;
use App\Application\Commands\Move;
use App\Domain\Coordinate;
use App\Domain\MovableInterface;
use App\Domain\MovableSnapshot;
use App\Domain\SnapshottingMovableInterface;
use Exception;
use PHPUnit\Framework\TestCase;
use RuntimeException;

class MacroCommandWithTransactionTest extends TestCase
{
    public function testTransaction(): void
    {
        $expectedPosition = new Coordinate(-2, 11);

        $stub = $this->createMock(MovableInterface::class);
        $stub
            ->expects($this->exactly(2))
            ->method('getVelocity')
            ->willReturn(new Coordinate(-7, 3));
        $stub
            ->expects($this->exactly(3))
            ->method('getPosition')
            ->will($this->onConsecutiveCalls(
                new Coordinate(12, 5),
                new Coordinate(5, 8),
                new Coordinate(-2, 11))
            );
        $stub
            ->expects($this->exactly(1))
            ->method('setVelocity');
        $stub
            ->expects($this->exactly(3))
            ->method('setPosition');


        $stub->method('createSnapshot')
            ->will($this->onConsecutiveCalls(
                new MovableSnapshot($stub, new Coordinate(12, 5), new Coordinate(-7, 3)),
                new MovableSnapshot($stub, new Coordinate(5, 8), new Coordinate(-7, 3)),
                new MovableSnapshot($stub, new Coordinate(-2, 11), new Coordinate(-7, 3))
            ));


        $moveWithException = $this->getMockBuilder(Move::class)
            ->setConstructorArgs(['object' => $stub])
            ->onlyMethods(['execute'])
            ->getMock();
        $moveWithException
            ->expects($this->once())
            ->method('execute')
            ->willThrowException(new Exception());

        $commands = [
            new Move($stub),
            new Move($stub),
            $moveWithException
        ];

        $macroCommand = new MacroCommandWithTransaction($commands);
        $macroCommand->execute();
        $this->assertEquals($expectedPosition, $stub->getPosition());
    }
}