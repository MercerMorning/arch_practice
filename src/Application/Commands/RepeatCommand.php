<?php

declare(strict_types=1);

namespace App\Application\Commands;

class RepeatCommand implements CommandInterface
{
    public function __construct(CommandInterface $command)
    {
        $this->command = $command;
    }

    public function execute()
    {
        $this->command->execute();
    }
}