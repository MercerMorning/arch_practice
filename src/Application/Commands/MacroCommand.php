<?php

namespace App\Application\Commands;

use App\Infrastructure\Exceptions\CommandException;
use Throwable;

class MacroCommand implements CommandInterface
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
        try {
            foreach ($this->commands as $command) {
                $command->execute();
            }
        } catch (Throwable $exception) {
            throw new CommandException();
        }
    }
}