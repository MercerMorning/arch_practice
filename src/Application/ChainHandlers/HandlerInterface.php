<?php

namespace App\Application\ChainHandlers;

use App\Domain\MovableInterface;

interface HandlerInterface
{
    public function setNext(HandlerInterface $handler): HandlerInterface;

    public function handle(array $request);
}