<?php

namespace App\Domain;

/**
 * Для объектов которые могут осуществлять поворот
 */
interface RotateInterface
{
    public function getAngular(): RotateCoordinate;

    public function getAngularVelocity(): RotateCoordinate;

    public function setAngular(RotateCoordinate $angular);
}