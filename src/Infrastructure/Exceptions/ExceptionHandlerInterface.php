<?php

namespace App\Infrastructure\Exceptions;

use Throwable;

interface ExceptionHandlerInterface
{
    public function handle(Throwable $exception);
}