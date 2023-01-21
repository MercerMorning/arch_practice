<?php

declare(strict_types=1);

namespace App\Application\Commands;

use App\Application\Helpers\VelocityChanger;
use App\Domain\VelocityChangableInterface;

class ChangeVelocity implements CommandInterface
{
    private VelocityChangableInterface $object;
    private float $velocityCorrection;

    /**
     * @param VelocityChangableInterface $object
     * @param float $velocityCorrection
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