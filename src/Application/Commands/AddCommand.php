<?php

declare(strict_types=1);

namespace App\Application\Commands;

use App\Infrastructure\Queue\QueueStorage;

/**
 * Добавляет команду в очередь
 */
class AddCommand implements CommandInterface
{
    /* @var $command CommandInterface */
    private CommandInterface $command;

    /**
     * @param CommandInterface $command
     */
    public function __construct(CommandInterface $command)
    {
        $this->command = $command;
    }

    public function execute()
    {
        QueueStorage::push($this->command);
    }
}