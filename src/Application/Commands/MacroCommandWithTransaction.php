<?php

namespace App\Application\Commands;

use Throwable;

class MacroCommandWithTransaction implements CommandInterface
{
    /* @var $commands CommandInterface[] */
    private array $commands;

    /**
     * @param array $commands
     */
    public function __construct(array $commands)
    {
        $this->commands = $commands;
    }

    public function execute()
    {
        /** @var CommandInterface|CommandTransactionInterface $command */
        foreach ($this->commands as $command) {
            try {
                $command->makeBackup();
                $command->execute();
            } catch (Throwable $exception) {
                $command->undo();
            }
        }
    }
}