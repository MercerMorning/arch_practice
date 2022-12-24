<?php

namespace App\Application\Commands;

use App\Application\Helpers\VelocityChanger;
use App\Domain\VelocityChangableInterface;
use Exception;

class ChangeVelocity implements CommandInterface
{
    private VelocityChangableInterface $object;

    /**
     * @param $object
     */
    public function __construct(VelocityChangableInterface $object)
    {
        $this->object = $object;
    }

    public function execute()
    {
        $this->object->setVelocity(
            VelocityChanger::makeChange($this->object->getVelocity(), $this->object->getIncrement())
        );
    }
}