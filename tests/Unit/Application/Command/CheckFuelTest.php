<?php

declare(strict_types=1);

namespace Tests\Unit\Application\Command;

use App\Application\Commands\CheckFuelCommand;
use App\Application\Exceptions\BurnFuelException;
use App\Application\Exceptions\CheckFuelException;
use App\Domain\FuelBurnableInterface;
use Exception;
use PHPUnit\Framework\TestCase;

class CheckFuelTest extends TestCase
{
    public function setUp(): void
    {
        $this->fuelBurnable = $this->createMock(FuelBurnableInterface::class);
        $this->checkFuel    = new CheckFuelCommand($this->fuelBurnable);
    }

    /**
     * @dataProvider fuelDataNegativeProvider
     *
     * @param array<string, int> $input
     * @throws Exception
     */
    public function testExecuteWithException(array $input): void
    {
        $this->fuelBurnable->expects($this->once())
            ->method('getLevel')
            ->willReturn($input['level']);
        $this->expectException(CheckFuelException::class);
        $this->checkFuel->execute();
    }

    /**
     * @return iterable<array<string, int>, int>
     */
    public function fuelDataNegativeProvider(): iterable
    {
        yield [
            [
                'level'    => 0,
            ],
            [
                'level'    => -1,
            ],
        ];
    }
}
