<?php

namespace Tests\Unit\Application\Command;

use App\Application\Commands\CommandInterface;
use App\Application\Commands\MacroCommandThrowingSourceException;
use App\Application\Commands\Move;
use App\Domain\Coordinate;
use App\Domain\MovableInterface;
use App\Domain\MovableSnapshot;
use App\Domain\SnapshottingMovableInterface;
use Exception;
use PHPUnit\Framework\TestCase;
use RuntimeException;

class MacroCommandThrowingSourceExceptionTest extends TestCase
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
            ->willThrowException(new RuntimeException());
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
        $macroCommand = new MacroCommandThrowingSourceException($commands);
        $this->expectException(RuntimeException::class);
        $macroCommand->execute();
    }
}