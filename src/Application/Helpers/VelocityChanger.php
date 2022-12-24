<?php

namespace App\Application\Helpers;

use App\Domain\Coordinate;

class VelocityChanger
{
    public static function makeChange(Coordinate $velocity, float $increment)
    {       
        $newX = $velocity->getX() * $increment;
        $newY = $velocity->getY() * $increment;
        return new Coordinate ($newX, $newY);    
    }
}
