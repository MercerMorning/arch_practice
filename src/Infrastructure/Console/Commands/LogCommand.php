<?php

declare(strict_types=1);

namespace App\Infrastructure\Console\Commands;

use App\Application\Commands\Log;
use Exception;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Input\{InputArgument, InputInterface};

#[AsCommand(
    name: 'app:log',
)]
class LogCommand extends Command
{
    protected static $defaultDescription = 'Логирование';

    /**
     * @throws Exception
     */
    protected function execute(InputInterface $input, OutputInterface $output) :int
    {
        try {
            throw new Exception('Это исключение');
        } catch (Exception $exception) {
            $log = new Log($exception);
            $log->execute();
        }

        return Command::SUCCESS;
    }
}
