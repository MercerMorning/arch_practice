<?php

declare(strict_types=1);

namespace App\AppBundle\Domains;

class EquationManager
{
    /**
     * Решает квадратное уравнение
     *
     * @param float|null $a
     * @param float|null $b
     * @param float|null $c
     *
     * @return array|null
     */
    public static function solve(?float $a, ?float $b = 0, ?float $c = 0): ?array
    {
        if (self::CompareWithZero($a)) {
            return null;
        }

        $discriminant = $b * $b - 4 * $a * $c;
        if ($discriminant > 0) {
            $x1 = (-$b + sqrt($discriminant)) / 2 * $a;
            $x2 = (-$b - sqrt($discriminant)) / 2 * $a;
        } elseif (self::CompareWithZero($discriminant, 0)) {
            $x1 = $x2 = (-$b) / 2 * $a;
        } else {
            return [];
        }

        return [(float)$x1, (float)$x2];
    }

    /**
     * Сравнивает числа с плавающей точкой с нулём
     *
     * @param float $a
     *
     * @return bool
     */
    private static function CompareWithZero(float $a): bool
    {
        return abs($a) < PHP_FLOAT_EPSILON;
    }
}
