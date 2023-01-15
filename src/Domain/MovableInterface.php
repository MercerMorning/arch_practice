<?php

namespace App\Domain;

interface MovableInterface
{
    public function getPosition(): Coordinate;

    public function getVelocity(): Coordinate;

    public function setPosition(Coordinate $position);
}