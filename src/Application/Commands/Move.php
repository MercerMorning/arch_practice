<?php

namespace App\Application\Commands;

use App\Application\Helpers\CoordinatesSummator;
use App\Domain\MovableInterface;

class Move implements CommandInterface
{
    private MovableInterface $object;

    /**
     * @param $object
     */
    public function __construct(MovableInterface $object)
    {
        $this->object = $object;
    }

    public function execute()
    {
        $this->object->setPosition(
            CoordinatesSummator::makeSum($this->object->getPosition(), $this->object->getVelocity())
        );
    }
}