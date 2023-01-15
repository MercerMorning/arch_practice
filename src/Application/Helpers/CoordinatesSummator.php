<?php
namespace App\Application\Helpers;

use App\Domain\Coordinate;

class CoordinatesSummator
{
    public static function makeSum(Coordinate ...$coordinates)
    {
        $result = [0, 0];

        foreach ($coordinates as $coordinate) {

            $result[0] += $coordinate->getX();
            $result[1] += $coordinate->getY();
        }
        return new Coordinate($result[0], $result[1]);
    }
}