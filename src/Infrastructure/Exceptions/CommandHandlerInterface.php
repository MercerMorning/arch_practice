<?php

namespace App\Infrastructure\Exceptions;

use Throwable;

interface CommandHandlerInterface
{
    public function handle(string $commandType, Throwable $exception);
}