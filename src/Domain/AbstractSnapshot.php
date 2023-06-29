<?php

namespace App\Domain;

abstract class AbstractSnapshot
{
    private SnapshottingInterface $object;

    abstract public function restore();
}