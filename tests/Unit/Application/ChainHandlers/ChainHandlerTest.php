<?php

namespace Tests\Unit\Application\ChainHandlers;

use App\Application\ChainHandlers\CheckCollisionHandler;
use App\Application\ChainHandlers\DefineAreaHandler;
use App\Application\Exceptions\CollisionException;
use App\Domain\Coordinate;
use App\Domain\MovableInterface;
use App\Infrastructure\Exceptions\CommandExceptionHandler;
use App\Infrastructure\Exceptions\ExceptionHandlerInterface;
use App\Infrastructure\InitScopeBasedIoCImplementation;
use App\Infrastructure\InversionOfControlContainer;
use App\Infrastructure\Queue\QueueListener;
use App\Infrastructure\Queue\QueueStorage;
use App\Infrastructure\Queue\QueueStorageInterface;
use Doctrine\Common\Collections\ArrayCollection;
use PHPUnit\Framework\TestCase;

class ChainHandlerTest extends TestCase
{
    public function testChain()
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

        $listener->listen();

        $stubOne = $this->createMock(MovableInterface::class);
        $stubOne->method('getVelocity')
            ->willReturn(new Coordinate(-7, 3));
        $stubOne->method('getPosition')
            ->willReturn(new Coordinate(12, 5));

        $stubTwo = $this->createMock(MovableInterface::class);
        $stubTwo->method('getVelocity')
            ->willReturn(new Coordinate(-7, 3));
        $stubTwo->method('getPosition')
            ->willReturn(new Coordinate(12, 5));

        $areas = new ArrayCollection([]);
        $updatedAreas = new ArrayCollection([]);
        InversionOfControlContainer::getInstance()->resolve(
            "IoC.Register",
            "game.1.objects.area",
            function () use ($areas) {
                return $areas;
            })->execute();
        InversionOfControlContainer::getInstance()->resolve(
            "IoC.Register",
            "game.1.objects.updatedArea",
            function () use ($updatedAreas) {
                return $updatedAreas;
            })->execute();
        InversionOfControlContainer::getInstance()->resolve(
            "IoC.Register",
            "game.1.object.1",
            function () use ($stubOne) {
                return $stubOne;
            })->execute();
        InversionOfControlContainer::getInstance()->resolve(
            "IoC.Register",
            "game.1.object.2",
            function () use ($stubTwo) {
                return $stubTwo;
            })->execute();


        $handler = new DefineAreaHandler();
        $handler->setNext(new CheckCollisionHandler());
        $handler->handle([
            'game_id' => 1,
            'object_id' => 1
        ]);
        $handler->handle([
            'game_id' => 1,
            'object_id' => 2
        ]);


//        $this->expectException(CollisionException::class);
    }
}