<?php

namespace App\Domain;

class RotateCoordinate
{
    /**
     * @var float Угол поворота
     */
    private float $angular;
    /**
     * @var float Угловая скорость
     */
    private float $angularVelocity;

    /**
     * @param float $angular
     * @param float $angularVelocity
     */
    public function __construct(float $angular, float $angularVelocity)
    {
        $this->angular = $angular;
        $this->angularVelocity = $angularVelocity;
    }

    /**
     * @return float
     */
    public function getAngular(): float
    {
        return $this->angular;
    }

    /**
     * @return float
     */
    public function getAngularVelocity(): float
    {
        return $this->angularVelocity;
    }
}