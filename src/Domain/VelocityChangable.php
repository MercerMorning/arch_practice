<?php

namespace App\Domain;

class VelocityChangable
{    
    private Coordinate $velocity;
    private float $angle;

    public function __construct(Coordinate $velocity, float $angle)
    {
        $this->velocity = $velocity;
        $this->angle = $angle;        
    }

    public function getAngle(): float
    {
        return $this->angle;
    }

    public function getVelocity(): Coordinate
    {
        return $this->velocity;
    }

    public function setVelocity(Coordinate $newVelocity)
    {
        $this->velocity = $newVelocity;
    }    
}
