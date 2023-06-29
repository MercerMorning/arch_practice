<?php

declare(strict_types=1);

namespace App\Infrastructure\Console\Commands;

use App\Domain\Coordinate;
use App\Domain\Spaceship;
use App\Infrastructure\App;
use App\Infrastructure\InversionOfControlContainer;
use App\Infrastructure\Route;
use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\{InputInterface};
use Symfony\Component\Console\Output\OutputInterface;

#[AsCommand(
    name: 'game:start',
)]
class GameServerCommand extends Command
{
    protected static $defaultDescription = 'Запускает игроквой сервер';

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $app = App::getInstance();

        $gameId = uniqid();

        echo 'game: ' . $gameId . PHP_EOL;
        $firstObjectId = uniqid();
        InversionOfControlContainer::getInstance()->resolve(
            "IoC.Register",
            "game." . $gameId .".object." . $firstObjectId,
            function () {
                return new Spaceship(new Coordinate(1, 1), new Coordinate(3, 3));
        })->execute();
        echo 'object1: ' . $firstObjectId . PHP_EOL;
        $secondObjectId = uniqid();
        InversionOfControlContainer::getInstance()->resolve(
            "IoC.Register",
            "game." . $gameId .".object." . $secondObjectId,
            function () {
                return new Spaceship(new Coordinate(1, 1), new Coordinate(3, 3));
            })->execute();
        echo 'object2: ' . $secondObjectId . PHP_EOL;

        $app->inConsole();
        $app->initialize();
    }
}
