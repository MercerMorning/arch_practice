<?php

declare(strict_types=1);

namespace App\Application\Commands;

class SecondRepeatCommand implements CommandInterface
{
    public function __construct(CommandInterface $command)
    {
        $this->command = $command;
    }

    public function execute()
    {
        throw new \ErrorException();
        return $this->command->execute();
    }
}