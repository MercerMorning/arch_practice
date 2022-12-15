<?php

declare(strict_types=1);

namespace App\Infrastructure\Console\Commands;

use App\Application\Commands\Move;
use App\Domain\Coordinate;
use App\Domain\Spaceship;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Input\{InputArgument, InputInterface};

#[AsCommand(
    name: 'app:move',
)]
class MoveCommand extends Command
{
    protected static $defaultDescription = 'Запускает движение объектов';

    protected function configure(): void
    {
//        $this
//            ->addArgument('a', InputArgument::OPTIONAL, 'Значение а')
//            ->addArgument('b', InputArgument::OPTIONAL, 'Значение b')
//            ->addArgument('c', InputArgument::OPTIONAL, 'Значение c');
    }

    protected function execute(InputInterface $input, OutputInterface $output) :int
    {
        $spaceship = new Spaceship(new Coordinate(1, 1), new Coordinate(2, 2));
        $move = new Move($spaceship);
        $move->execute();
        var_dump($spaceship->getPosition());
        return 1;
    }
}
