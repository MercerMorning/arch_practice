<?php

namespace App\Domain;

class MovableSnapshot extends AbstractSnapshot
{
    private MovableInterface $object;
    private Coordinate $position;
    private Coordinate $velocity;

    public function __construct(MovableInterface $object, Coordinate $position, Coordinate $velocity)
    {
        $this->object = $object;
        $this->position = $position;
        $this->velocity = $velocity;
    }

    public function restore()
    {
        $this->object->setPosition($this->position);
        $this->object->setVelocity($this->velocity);
    }
}