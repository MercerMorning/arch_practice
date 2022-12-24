<?php

namespace App\Application\Commands;

use App\Application\Helpers\VelocityChanger;
use App\Domain\VelocityChangableInterface;
use Exception;

class ChangeVelocity implements CommandInterface
{
    private VelocityChangableInterface $object;
    private float $velocityCorrection;

    /**
     * @param $object
     */
    public function __construct(VelocityChangableInterface $object, float $velocityCorrection)
    {
        $this->object = $object;
        $this->velocityCorrection = $velocityCorrection;
    }

    public function execute()
    {
        $this->object->setVelocity(
            VelocityChanger::makeChange($this->object->getVelocity(), $this->velocityCorrection)
        );
    }
}