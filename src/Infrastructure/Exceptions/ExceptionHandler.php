<?php

namespace App\Infrastructure\Exceptions;

use App\Application\Commands\CommandInterface;
use Throwable;

class ExceptionHandler implements ExceptionHandlerInterface
{
    public function handle(CommandInterface $command, Throwable $exception)
    {
        return self::class;
    }
}