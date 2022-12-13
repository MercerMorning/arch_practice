<?php

declare(strict_types=1);

namespace App\AppBundle\Domains;

use App\AppBundle\Domains\Exceptions\EqualsZeroException;

class EquationManager
{
    /**
     * Решает квадратное уравнение
     *
     * @param float|null $a
     * @param float|null $b
     * @param float|null $c
     *
     * @return array
     * @throws EqualsZeroException
     */
    public static function solve(?float $a, ?float $b = 0, ?float $c = 0): array
    {
        if (self::CheckLessThanZero($a)) {
            throw new EqualsZeroException('Значение \'a\' не может быть равен нулю');
        }

        $discriminant = $b * $b - 4 * $a * $c;
        if ($discriminant > 0) {
            $x1 = (-$b + sqrt($discriminant)) / (2 * $a);
            $x2 = (-$b - sqrt($discriminant)) / (2 * $a);
        } elseif (self::CheckLessThanZero($discriminant)) {
            $x1 = $x2 = (-$b) / 2 * $a;
        } else {
            return [];
        }

        return [(float)$x1, (float)$x2];
    }

    /**
     * Сравнивает числа с плавающей точкой с нулём
     *
     * @param float $num
     *
     * @return bool
     */
    private static function CheckLessThanZero(float $num): bool
    {
        return abs($num) < PHP_FLOAT_EPSILON && abs($num) >= 0;
    }
}
