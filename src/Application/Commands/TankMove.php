<?php

namespace App\Application\Commands;

use App\Application\Helpers\CoordinatesSummator;
use App\Domain\MovableInterface;
use App\Domain\TankOperationsMovableInterface;

class TankMove implements CommandInterface
{
    private MovableInterface $object;

    /**
     * @param $object
     */
    public function __construct(TankOperationsMovableInterface $object)
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