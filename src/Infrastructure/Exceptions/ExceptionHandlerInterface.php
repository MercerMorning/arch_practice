<?php

namespace App\Infrastructure\Exceptions;

use App\Application\Commands\CommandInterface;
use Throwable;

interface ExceptionHandlerInterface
{
    public function handle(CommandInterface$command, Throwable $exception): void;
}