<?php

declare(strict_types=1);

namespace App\Application\Commands;

use App\Application\Exceptions\BurnFuelException;
use App\Application\Exceptions\CheckFuelException;
use App\Domain\FuelBurnableInterface;
use Exception;

/**
 * Проверяет уровень топлива
 */
class CheckFuelCommand implements CommandInterface
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
        $level = $this->fuelBurnable->getLevel();

        if ($level <= 0) {
            throw new CheckFuelException("The object has run out of fuel");
        }
    }
}