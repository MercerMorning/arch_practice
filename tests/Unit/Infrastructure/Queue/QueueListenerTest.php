<?php

use App\Application\Commands\CommandInterface;
use App\Infrastructure\Queue\QueueListener;
use App\Infrastructure\Queue\QueueStorageInterface;

class QueueListenerTest extends \PHPUnit\Framework\TestCase
{
    public function testListen()
    {
        $storageMock = $this->createMock(QueueStorageInterface::class);
        $commandMock = $this->getMockBuilder(CommandInterface::class)
            ->getMock();
        $commandMock->expects($this->once())->method('execute');
        $storageMock->method('take')
            ->will($this->onConsecutiveCalls(
                $commandMock,
                null
            ));
        $listener = new QueueListener($storageMock);
        $listener->listen();
    }
}