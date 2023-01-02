<?php

namespace App\Infrastructure\Exceptions;

use Throwable;

interface HandlerInterface
{
    public function handle(Throwable $exception);
}