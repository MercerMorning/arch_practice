<?php

namespace Tests\Unit;

use App\Application\Commands\AddForceQueueStopCommandToQueue;
use App\Application\Commands\AddSoftQueueStopCommandToQueue;
use App\Application\Commands\CommandInterface;
use App\Application\Commands\MoveToCommand;
use App\Infrastructure\Exceptions\CommandExceptionHandler;
use App\Infrastructure\Exceptions\ExceptionHandlerInterface;
use App\Infrastructure\InitScopeBasedIoCImplementation;
use App\Infrastructure\InversionOfControlContainer;
use App\Infrastructure\Queue\QueueListener;
use App\Infrastructure\Queue\QueueStorage;
use App\Infrastructure\Queue\QueueStorageInterface;
use App\Infrastructure\Queue\Statements\Common;
use App\Infrastructure\Queue\Statements\Finished;
use App\Infrastructure\Queue\Statements\MoveTo;
use PHPUnit\Framework\MockObject\MockObject;
use PHPUnit\Framework\TestCase;
use function PHPUnit\Framework\assertEquals;

class ThreadTest extends TestCase
{
    public function testSoftQueueStop()
    {
        $container = new InversionOfControlContainer();
        InversionOfControlContainer::setInstance($container);
        $command = new InitScopeBasedIoCImplementation();
        $command->execute();


        $container->resolve("IoC.Register", QueueStorageInterface::class, function () {
            return new QueueStorage();
        })->execute();
        $container->resolve("IoC.Register", ExceptionHandlerInterface::class, function () {
            return new CommandExceptionHandler();
        })->execute();


        $container->resolve("IoC.Register", QueueListener::class, function () {
            return new QueueListener(
                InversionOfControlContainer::getInstance()->resolve(QueueStorageInterface::class),
                InversionOfControlContainer::getInstance()->resolve(ExceptionHandlerInterface::class),
            );
        })->execute();

        $container->resolve("IoC.Register", 'stopThread', function () {
            return new AddSoftQueueStopCommandToQueue();
        })->execute();

        /**
         * @var $listener QueueListener
         */
        $listener = $container->resolve(QueueListener::class);

        /**
         * @return MockObject[]
         */
        $mocks = [
            $this->createMock(CommandInterface::class),
            $this->createMock(CommandInterface::class),
        ];
        $mocks[0]->expects(self::once())->method('execute');
        $mocks[1]->expects(self::once())->method('execute');
        $commands =
            [
                $mocks[0],
                $mocks[1],
            ];

        foreach ($commands as $command) {
            QueueStorage::push($command);
        }

        $container->resolve("stopThread")->execute();

        $listener->listen();
    }

    public function testForceQueueStop()
    {
        $container = new InversionOfControlContainer();
        InversionOfControlContainer::setInstance($container);
        $command = new InitScopeBasedIoCImplementation();
        $command->execute();


        $container->resolve("IoC.Register", QueueStorageInterface::class, function () {
            return new QueueStorage();
        })->execute();
        $container->resolve("IoC.Register", ExceptionHandlerInterface::class, function () {
            return new CommandExceptionHandler();
        })->execute();


        $container->resolve("IoC.Register", QueueListener::class, function () {
            return new QueueListener(
                InversionOfControlContainer::getInstance()->resolve(QueueStorageInterface::class),
                InversionOfControlContainer::getInstance()->resolve(ExceptionHandlerInterface::class),
            );
        })->execute();

        $container->resolve("IoC.Register", 'stopThread', function () {
            return new AddForceQueueStopCommandToQueue();
        })->execute();

        /**
         * @var $listener QueueListener
         */
        $listener = $container->resolve(QueueListener::class);

        /**
         * @return MockObject[]
         */
        $mocks = [
            $this->createMock(CommandInterface::class),
            $this->createMock(CommandInterface::class),
        ];
        $mocks[0]->expects(self::never())->method('execute');
        $mocks[1]->expects(self::never())->method('execute');

        $commands =
            [
                $mocks[0],
                $mocks[1],
            ];



        foreach ($commands as $command) {
            QueueStorage::push($command);
        }

        $container->resolve("stopThread")->execute();

        $listener->listen();
    }

    public function testChangeStatement()
    {
        $container = new InversionOfControlContainer();
        InversionOfControlContainer::setInstance($container);
        $command = new InitScopeBasedIoCImplementation();
        $command->execute();


        $container->resolve("IoC.Register", QueueStorageInterface::class, function () {
            return new QueueStorage();
        })->execute();
        $container->resolve("IoC.Register", ExceptionHandlerInterface::class, function () {
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


        /**
         * @return MockObject[]
         */
        $mocks = [
            $this->createMock(CommandInterface::class),
            $this->createMock(CommandInterface::class),
        ];

        $commands =
            [
                $mocks[0],
                $mocks[1],
            ];

        foreach ($commands as $command) {
            QueueStorage::push($command);
        }

        $listener->listen();
        assertEquals(new Common(), $listener->getStatement());
    }

    public function testHardStopWithStatement()
    {
        $container = new InversionOfControlContainer();
        InversionOfControlContainer::setInstance($container);
        $command = new InitScopeBasedIoCImplementation();
        $command->execute();


        $container->resolve("IoC.Register", QueueStorageInterface::class, function () {
            return new QueueStorage();
        })->execute();
        $container->resolve("IoC.Register", ExceptionHandlerInterface::class, function () {
            return new CommandExceptionHandler();
        })->execute();


        $container->resolve("IoC.Register", QueueListener::class, function () {
            return new QueueListener(
                InversionOfControlContainer::getInstance()->resolve(QueueStorageInterface::class),
                InversionOfControlContainer::getInstance()->resolve(ExceptionHandlerInterface::class),
            );
        })->execute();

        $container->resolve("IoC.Register", 'stopThread', function () {
            return new AddForceQueueStopCommandToQueue(); // Hard stop
        })->execute();

        /**
         * @var $listener QueueListener
         */
        $listener = $container->resolve(QueueListener::class);


        /**
         * @return MockObject[]
         */
        $mocks = [
            $this->createMock(CommandInterface::class),
            $this->createMock(CommandInterface::class),
        ];
        $mocks[0]->expects(self::never())->method('execute');
        $mocks[1]->expects(self::never())->method('execute');

        $commands =
            [
                $mocks[0],
                $mocks[1],
            ];


        foreach ($commands as $command) {
            QueueStorage::push($command);
        }

        $container->resolve("stopThread")->execute();

        $listener->listen();
        assertEquals(new Finished(), $listener->getStatement());
    }

    public function testChangeToMoveToStatement()
    {
        $container = new InversionOfControlContainer();
        InversionOfControlContainer::setInstance($container);
        $command = new InitScopeBasedIoCImplementation();
        $command->execute();


        $container->resolve("IoC.Register", QueueStorageInterface::class, function () {
            return new QueueStorage();
        })->execute();
        $container->resolve("IoC.Register", ExceptionHandlerInterface::class, function () {
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
                new MoveToCommand(),
                $this->createMock(CommandInterface::class),
            ];

        foreach ($commands as $command) {
            QueueStorage::push($command);
        }

        $listener->listen();
        assertEquals(new MoveTo(), $listener->getStatement());
    }


}