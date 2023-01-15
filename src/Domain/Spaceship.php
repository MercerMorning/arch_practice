<?php

namespace App\Domain;

class Spaceship implements MovableInterface
{
    private Coordinate $position;
    private Coordinate $velocity;

    public function __construct(Coordinate $position, Coordinate $velocity)
    {
        $this->position = $position;
        $this->velocity = $velocity;
    }

    public function getPosition(): Coordinate
    {
        return $this->position;
    }

    public function setPosition(Coordinate $position)
    {
        $this->position = $position;
    }

    public function getVelocity(): Coordinate
    {
        return $this->velocity;
    }
}