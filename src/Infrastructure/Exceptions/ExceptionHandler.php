<?php

namespace App\Infrastructure\Exceptions;

use Throwable;

class ExceptionHandler implements ExceptionHandlerInterface
{

    public function handle(Throwable $exception)
    {
        return self::class;
    }
}