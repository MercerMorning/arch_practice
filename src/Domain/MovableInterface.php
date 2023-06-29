<?php

namespace App\Domain;

interface MovableInterface extends SnapshottingInterface
{
    public function getPosition(): Coordinate;

    public function getVelocity(): Coordinate;

    public function setPosition(Coordinate $position);

    public function setVelocity(Coordinate $velocity);
}