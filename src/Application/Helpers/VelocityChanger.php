<?php

namespace App\Application\Helpers;

use App\Domain\Coordinate;

class VelocityChanger
{
    public static function makeChange(float $angle, Coordinate $velocity)
    {       
        $velocityModule  = sqrt(pow($velocity->getX(), 2) + pow($velocity->getY(), 2));

        return new Coordinate($velocityModule * cos($angle),  $velocityModule * sin($angle));    
    }
}
