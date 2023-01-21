<?php

namespace App\Application\Commands;

use Throwable;

class MacroCommandThrowingSourceException implements CommandInterface
{
    /* @var $commands array */
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
        try {
            foreach ($this->commands as $command) {
                try {
                    $command->makeBackup();
                    $command->execute();
                } catch (Throwable $exception) {
                    $command->undo();
                    throw $exception;
                }
            }
        } catch (Throwable $exception) {
            throw $exception;
        }
    }
}