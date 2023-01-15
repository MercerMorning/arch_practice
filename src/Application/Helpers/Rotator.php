<?php

namespace App\Application\Helpers;

use App\Domain\RotateCoordinate;

class Rotator
{
    /**
     * Делает поворот
     *
     * @param RotateCoordinate ...$coordinates
     *
     * @return RotateCoordinate
     */
    public static function makeRotate(RotateCoordinate ...$coordinates): RotateCoordinate
    {
        $result = [0, 0];

        foreach ($coordinates as $coordinate) {
            $result[0] += $coordinate->getAngular();
            $result[1] += $coordinate->getAngularVelocity();
        }

        return new RotateCoordinate($result[0], $result[1]);
    }
}