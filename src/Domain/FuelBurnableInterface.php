<?php

namespace App\Domain;
interface FuelBurnableInterface
{
    public function getLevel(): int;

    public function setLevel(int $level): void;

    public function getVelocity(): int;
}