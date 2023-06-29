<?php

namespace Tests\Unit\Application\Command;

use App\Application\Commands\CommandInterface;
use App\Application\Commands\MacroCommand;
use App\Infrastructure\Exceptions\CommandException;
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
}