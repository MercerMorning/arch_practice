<?php

namespace App\Application\Helpers;

use App\Domain\Coordinate;

class VelocityChanger
{
    public static function makeChange(float $angle, Coordinate ...$coordinates)
    {
        $velocityModule = 0;

        foreach ($coordinates as $coordinate) {
            $velocityModule  += pow($coordinate, 2);
        }

        $velocityModule = sqrt($velocityModule);

        return new Coordinate($velocityModule * cos($angle),  $velocityModule * sin($angle));
    }
}
