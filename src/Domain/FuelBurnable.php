<?php

declare(strict_types=1);

namespace App\Domain;
class FuelBurnable implements FuelBurnableInterface
{
    private int $level;
    private int $velocity;

    public function __construct(int $level, int $velocity)
    {
        $this->level = $level;
        $this->velocity = $velocity;
    }

    public function getLevel(): int
    {
        return $this->level;
    }

    public function setLevel(int $level): void
    {
        $this->level = $level;
    }

    public function getVelocity(): int
    {
        return $this->velocity;
    }
}