<?php

namespace Tests\Unit\Application\Command;

use App\Application\Commands\AddCommand;
use App\Application\Commands\BurnFuelCommand;
use App\Application\Commands\CheckFuelCommand;
use App\Application\Commands\CommandInterface;
use App\Application\Commands\MacroCommand;
use App\Application\Commands\Move;
use App\Domain\Coordinate;
use App\Domain\MovableFuelBurnableInterface;
use App\Domain\MovableInterface;
use App\Infrastructure\Exceptions\CommandException;
use App\Infrastructure\Queue\QueueStorage;
use Exception;
use PHPUnit\Framework\TestCase;

class MacroCommandTest extends TestCase
{
    public function testInterruptingWithException(): void
    {
        $firstCommand = $this->getMockBuilder(CommandInterface::class)
            ->getMock();
        $firstCommand
            ->expects($this->once())
            ->method('execute');
        $secondCommand = $this->getMockBuilder(CommandInterface::class)
            ->getMock();
        $secondCommand
            ->expects($this->once())
            ->method('execute')
            ->willThrowException(new Exception());
        $thirdCommand = $this->getMockBuilder(CommandInterface::class)
            ->getMock();
        $thirdCommand
            ->expects($this->never())
            ->method('execute');
        $commands = [
            $firstCommand,
            $secondCommand,
            $thirdCommand
        ];
        $macroCommand = new MacroCommand($commands);
        $this->expectException(CommandException::class);
        $macroCommand->execute();
    }

    public function testMoveWithBurningFuel()
    {
        $stub = $this->createMock(MovableFuelBurnableInterface::class);
        $stub
            ->expects($this->exactly(2))
            ->method('getLevel')
            ->willReturn(3);
        $stub
            ->expects($this->once())
            ->method('getConsumption')
            ->willReturn(1);
        $stub
            ->expects($this->once())
            ->method('getVelocity')
            ->willReturn(new Coordinate(-7, 3));
        $stub
            ->expects($this->once())
            ->method('getPosition')
            ->willReturn(new Coordinate(12, 5));

        $macroCommand = new MacroCommand([
            new CheckFuelCommand($stub),
            new BurnFuelCommand($stub),
            new Move($stub)
        ]);

        $macroCommand->execute();
    }

    public function testLongMoveOperation()
    {
        $stub = $this->createMock(MovableInterface::class);
        $commandForAdding = new Move($stub);
        $queueStorage = new QueueStorage();
        $macroCommand = new MacroCommand([
            new AddCommand($commandForAdding),
        ]);
        $macroCommand->execute();
        $this->assertEquals($commandForAdding, $queueStorage->take());
    }
}