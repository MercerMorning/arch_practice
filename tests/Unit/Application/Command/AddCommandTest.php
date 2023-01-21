<?php

declare(strict_types=1);

namespace Tests\Unit\Application\Command;

use App\Application\Commands\AddCommand;
use App\Application\Commands\Move;
use App\Domain\MovableInterface;
use App\Infrastructure\Queue\QueueStorage;
use PHPUnit\Framework\TestCase;

class AddCommandTest extends TestCase
{
    public function testAddMoveCommand(): void
    {
        $queue = new QueueStorage();
        $move = new Move($this->createMock(MovableInterface::class));

        $addCommand = new AddCommand($move);
        $addCommand->execute();

        $command = $queue->take();
        $this->assertContainsOnlyInstancesOf(
            Move::class,
            [$command],
            'Ошибка команды, добавляющей команды в очередь'
        );
    }
}

