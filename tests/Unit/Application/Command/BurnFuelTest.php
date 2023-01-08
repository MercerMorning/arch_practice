<?php

declare(strict_types=1);

namespace Tests\Unit\Application\Command;

use App\Application\Commands\BurnFuel;
use App\Application\Exceptions\BurnFuelException;
use App\Domain\FuelBurnableInterface;
use Exception;
use PHPUnit\Framework\TestCase;

class BurnFuelTest extends TestCase
{
    public function setUp()
    {
        $this->fuelBurnable = $this->createMock(FuelBurnableInterface::class);
        $this->burnFuel     = new BurnFuel($this->fuelBurnable);
    }

    /**
     * @dataProvider fuelDataProvider
     *
     * @param array<string, int> $input
     * @throws Exception
     */
    public function testExecuteWithoutException(array $input, int $expected): void
    {
        $this->fuelBurnable->expects($this->once())
            ->method('getLevel')
            ->willReturn($input['level']);
        $this->fuelBurnable->expects($this->once())
            ->method('getVelocity')
            ->willReturn($input['velocity']);
        $this->fuelBurnable->expects($this->once())
            ->method('setLevel')
            ->with($expected);

        $this->burnFuel->execute();
    }

    /**
     * @return iterable<array<string, int>, int>
     */
    public function fuelDataProvider(): iterable
    {
        yield [
            [
                'level'    => 100,
                'velocity' => 10
            ],
            90
        ];
        yield [
            [
                'level'    => 10,
                'velocity' => 10
            ],
            0
        ];
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
        $this->fuelBurnable->expects($this->once())
            ->method('getVelocity')
            ->willReturn($input['velocity']);
        $this->fuelBurnable->expects($this->never());

        $this->burnFuel->execute();
        $this->expectException(BurnFuelException::class);
    }

    /**
     * @return iterable<array<string, int>, int>
     */
    public function fuelDataNegativeProvider(): iterable
    {
        yield [
            [
                'level'    => 9,
                'velocity' => 10
            ],
        ];
    }
}
