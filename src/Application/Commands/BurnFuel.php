<?php

declare(strict_types=1);

namespace App\Application\Commands;

use App\Application\Exceptions\BurnFuelException;
use App\Domain\FuelBurnableInterface;
use Exception;
class BurnFuel implements CommandInterface
{
    private FuelBurnableInterface $fuelBurnable;

    public function __construct(FuelBurnableInterface $fuelBurnable)
    {
        $this->fuelBurnable = $fuelBurnable;
    }

    /**
     * @throws Exception
     */
    public function execute(): void
    {
        $level = $this->fuelBurnable->getLevel() - $this->fuelBurnable->getVelocity();

        if ($level < 0) {
            throw new BurnFuelException("The object has run out of fuel");
        }

        $this->fuelBurnable->setLevel($level);
    }

    public function makeBackup()
    {
        // TODO: Implement makeBackup() method.
    }

    public function undo()
    {
        // TODO: Implement undo() method.
    }
}