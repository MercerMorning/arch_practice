<?

namespace App\Domain;

interface VelocityChangableInterface
{
    public function getVelocity(): Coordinate;

    public function getAngle() : float;

    public function setVelocity(Coordinate $newVelocity);
}