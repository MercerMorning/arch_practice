<?php

namespace App\Domain;

interface TankOperationsMovableInterface
{
    public function getPosition(): Coordinate;

    public function getVelocity(): Coordinate;

    public function setPosition(Coordinate $position);
}