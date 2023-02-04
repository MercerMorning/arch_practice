<?php

namespace Tests\Unit;

use App\Application\Commands\CommandInterface;
use App\Application\Commands\SoftQueueStopCommand;
use App\Infrastructure\Exceptions\CommandExceptionHandler;
use App\Infrastructure\Exceptions\ExceptionHandlerInterface;
use App\Infrastructure\InitScopeBasedIoCImplementation;
use App\Infrastructure\InversionOfControlContainer;
use App\Infrastructure\Queue\QueueListener;
use App\Infrastructure\Queue\QueueStorage;
use App\Infrastructure\Queue\QueueStorageInterface;
use App\Infrastructure\ScopeBasedResolveDependencyStrategy;
use PHPUnit\Framework\TestCase;

class ThreadTest extends TestCase
{
    public function testStartThread()
    {
        $container = new InversionOfControlContainer();
        InversionOfControlContainer::setInstance($container);
        $command = new InitScopeBasedIoCImplementation();
        $command->execute();


        $container->resolve("IoC.Register", QueueStorageInterface::class, function () {
            return new QueueStorage();
        })->execute();
        $container->resolve("IoC.Register",ExceptionHandlerInterface::class, function () {
            return new CommandExceptionHandler();
        })->execute();


        $container->resolve("IoC.Register", QueueListener::class, function () {
            return new QueueListener(
                InversionOfControlContainer::getInstance()->resolve(QueueStorageInterface::class),
                InversionOfControlContainer::getInstance()->resolve(ExceptionHandlerInterface::class),
            );
        })->execute();

        /**
         * @var $listener QueueListener
         */
        $listener = $container->resolve(QueueListener::class);

        $commands =
            [
                $this->createMock(CommandInterface::class)->method('execute')->willReturn('1'),
                $this->createMock(CommandInterface::class)->method('execute')->willReturn('2'),
                new SoftQueueStopCommand(),
                $this->createMock(CommandInterface::class)->method('execute')->willReturn('3'),
            ];

        foreach ($commands as $command) {
            QueueStorage::push($command);
        }

        $listener->listen();
    }
}