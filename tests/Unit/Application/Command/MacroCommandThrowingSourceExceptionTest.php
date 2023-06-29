<?php

namespace Tests\Unit\Application\Command;

use App\Application\Commands\MacroCommandThrowingSourceException;
use App\Application\Commands\Move;
use App\Domain\MovableInterface;
use PHPUnit\Framework\TestCase;
use RuntimeException;

class MacroCommandThrowingSourceExceptionTest extends TestCase
{
    public function testInterruptingWithException(): void
    {
        $firstCommand = $this->getMockBuilder(Move::class)
            ->setConstructorArgs(['object' => $this->getMockBuilder(MovableInterface::class)->getMock()])
            ->getMock();
        $firstCommand
        ->expects($this->once())
        ->method('execute');

        $secondCommand = $this->getMockBuilder(Move::class)
            ->setConstructorArgs(['object' => $this->getMockBuilder(MovableInterface::class)->getMock()])
            ->getMock();
        $secondCommand
            ->expects($this->once())
            ->method('execute')
            ->willThrowException(new RuntimeException());

        $thirdCommand = $this->getMockBuilder(Move::class)
            ->setConstructorArgs(['object' => $this->getMockBuilder(MovableInterface::class)->getMock()])
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