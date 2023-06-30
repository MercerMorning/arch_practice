<?php

namespace App\Application\ChainHandlers;

use App\Domain\MovableInterface;

abstract class AbstractHandler implements HandlerInterface
{
    /**
     * @var HandlerInterface
     */
    private $nextHandler;

    public function setNext(HandlerInterface $handler): HandlerInterface
    {
        $this->nextHandler = $handler;
        // Возврат обработчика отсюда позволит связать обработчики простым
        // способом, вот так:
        // $monkey->setNext($squirrel)->setNext($dog);
        return $handler;
    }

    public function handle(array $request)
    {
        if ($this->nextHandler) {
            return $this->nextHandler->handle($request);
        }

        return null;
    }
}