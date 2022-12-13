<?php

namespace Tests\Unit;

use App\AppBundle\Domains\EquationManager;
use App\AppBundle\Domains\Exceptions\EqualsZeroException;
use PHPUnit\Framework\TestCase;

class SolveTest extends TestCase
{
    private EquationManager $equation;

    public function __construct(?string $name = null, array $data = [], $dataName = '')
    {
        $this->equation = new EquationManager();
        parent::__construct($name, $data, $dataName);
    }

    public function testHaveNotRoots()
    {
        // x^2+1 = 0
        $value = $this->equation::solve(1, 0, 1);
        $this->assertSame([], $value);
    }

    public function testHaveTwoRoots()
    {
        // x^2-1 = 0
        $value = $this->equation::solve(1, 0, -1);
        $this->assertEquals([1, -1], $value);
    }

    public function testHaveOneRoot()
    {
        // x^2+2x+1
        $value = $this->equation::solve(0.05, 0.7, -1.8);
        $this->assertEquals([2.219544457292888, -16.219544457292887], $value);
    }

    public function testIsNull()
    {
        $this->expectException(EqualsZeroException::class);
        // a=0
        $this->equation::solve(0);
    }
}