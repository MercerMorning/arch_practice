<?php

declare(strict_types=1);

namespace App\Application\Commands;

use App\Application\Helpers\CoordinatesSummator;
use App\Domain\MovableInterface;

class BurnFuelCommand implements CommandInterface
{
    private MovableInterface $object;

    /**
     * @param MovableInterface $object
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