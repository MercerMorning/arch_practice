<?php

use App\Application\Commands\CommandInterface;
use App\Infrastructure\Exceptions\ExceptionHandlerInterface;
use App\Infrastructure\Queue\QueueListener;
use App\Infrastructure\Queue\QueueStorageInterface;
use PHPUnit\Framework\TestCase;

class QueueListenerTest extends TestCase
{
    public function testListenWithoutExceptions()
    {
        $storageMock = $this->createMock(QueueStorageInterface::class);
        $commandMock = $this->getMockBuilder(CommandInterface::class)
            ->getMock();
        $errorHandlerMock = $this->createMock(ExceptionHandlerInterface::class);
        $commandMock->expects($this->once())->method('execute');
        $storageMock->method('take')
            ->will($this->onConsecutiveCalls(
                $commandMock,
                null
            ));
        $listener = new QueueListener($storageMock, $errorHandlerMock);
        $listener->listen();
    }

    public function testListenWithException()
    {
        $storageMock = $this->createMock(QueueStorageInterface::class);
        $commandMock = $this->getMockBuilder(CommandInterface::class)
            ->getMock();
        $commandMock->method('execute')->willThrowException(new Exception());
        $commandMock->expects($this->once())->method('execute');
        $errorHandlerMock = $this->createMock(ExceptionHandlerInterface::class);
        $errorHandlerMock->expects($this->once())->method('handle');
        $storageMock->method('take')
            ->will($this->onConsecutiveCalls(
                $commandMock,
                null
            ));
        $listener = new QueueListener($storageMock, $errorHandlerMock);
        $listener->listen();
    }
}