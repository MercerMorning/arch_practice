<?php

namespace App\Application\Commands;

use App\Application\Helpers\Rotator;
use App\Domain\RotateInterface;

class Rotate implements CommandInterface
{
    private RotateInterface $object;

    /**
     * @param RotateInterface $object
     */
    public function __construct(RotateInterface $object)
    {
        $this->object = $object;
    }

    public function execute()
    {
        $this->object->setAngular(
            Rotator::makeRotate($this->object->getAngular(), $this->object->getAngularVelocity())
        );
    }
}