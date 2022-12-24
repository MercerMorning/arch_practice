<?php

namespace App\Application\Helpers;

use App\Domain\Coordinate;

class VelocityChanger
{
    public static function makeChange(Coordinate $velocity, float $velocityCorrection)
    {       
        $newX = $velocity->getX() * $velocityCorrection;
        $newY = $velocity->getY() * $velocityCorrection;
        return new Coordinate ($newX, $newY);    
    }
}
