<?php

namespace App\Support;

class Format
{
    public static function quantity(int|float|string|null $value, int $precision = 3): string
    {
        $number = (float) ($value ?? 0);

        if (fmod($number, 1.0) === 0.0) {
            return number_format($number, 0, '.', ',');
        }

        return rtrim(rtrim(number_format($number, $precision, '.', ','), '0'), '.');
    }

    public static function quantityInput(int|float|string|null $value, int $precision = 3): string
    {
        $number = (float) ($value ?? 0);

        if (fmod($number, 1.0) === 0.0) {
            return (string) (int) $number;
        }

        return rtrim(rtrim(number_format($number, $precision, '.', ''), '0'), '.');
    }
}
