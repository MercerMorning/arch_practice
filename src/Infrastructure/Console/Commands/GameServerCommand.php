<?php

declare(strict_types=1);

namespace App\Infrastructure\Console\Commands;

use App\Application\CreatedCodeReceiver;
use App\Application\DTO\QueueConnectionDTO;
use App\Infrastructure\App;
use App\Infrastructure\CodeGenerator;
use App\Infrastructure\InitScopeBasedIoCImplementation;
use App\Infrastructure\InversionOfControlContainer;
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
        $app->inConsole();
        $app->initialize();
    }
}
