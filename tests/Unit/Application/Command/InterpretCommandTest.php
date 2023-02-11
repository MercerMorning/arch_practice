<?php

declare(strict_types=1);

namespace Tests\Unit\Application\Command;

use App\Application\Commands\InterpretCommand;
use App\Domain\Coordinate;
use App\Domain\Spaceship;
use App\Infrastructure\App;
use App\Infrastructure\Exceptions\CommandExceptionHandler;
use App\Infrastructure\InversionOfControlContainer;
use App\Infrastructure\Queue\QueueListener;
use App\Infrastructure\Queue\QueueStorage;
use PHPUnit\Framework\TestCase;

class InterpretCommandTest extends TestCase
{
    public function testExecuteWithoutException(): void
    {
        App::getInstance();
        $gameId = 1;
        $objectId = 1;
        $spaceship = new Spaceship(new Coordinate(1, 1), new Coordinate(3, 3));
        InversionOfControlContainer::getInstance()->resolve(
            "IoC.Register",
            "game." . $gameId . ".object." . $objectId,
            function () use ($spaceship){
                return $spaceship;
            })->execute();

        $body =  json_encode([
            'game_id' => 1,
            'object_id' => 1,
            'operation_id' => 1,
        ]);
        $command = new InterpretCommand($body);
        $command->execute();

        $queueListner = new QueueListener(new QueueStorage(), new CommandExceptionHandler());
        $queueListner->listen();
        $object = InversionOfControlContainer::getInstance()->resolve(
            "game." . $gameId . ".object." . $objectId);

        $this->assertEquals(new Coordinate(4, 4), $object->getPosition());
    }
}
