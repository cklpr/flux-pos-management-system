<?php

namespace App\Helpers;

class Currency
{
    public static function symbol(): string
    {
        return '₱';
    }

    public static function format(float|int|null $amount): string
    {
        $value = $amount === null ? 0 : $amount;

        return self::symbol() . number_format((float) $value, 2, '.', ',');
    }
}
