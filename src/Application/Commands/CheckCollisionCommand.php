<?php

namespace App\Application\Commands;

use App\Application\Exceptions\CollisionException;
use App\Domain\MovableInterface;

class CheckCollisionCommand implements CommandInterface
{
    private MovableInterface $firstObject;
    private MovableInterface $secondObject;
    public function __construct(MovableInterface $firstObject, MovableInterface $secondObject)
    {
        $this->firstObject = $firstObject;
        $this->secondObject = $secondObject;
    }

    public function execute()
    {
        if (
            $this->firstObject->getPosition()->getX() === $this->secondObject->getPosition()->getX() &&
            $this->firstObject->getPosition()->getY() === $this->secondObject->getPosition()->getY()
        ) {
            throw new CollisionException();
        }
    }
}