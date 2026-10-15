<?php

namespace App\Support;

use Carbon\CarbonInterface;
use Illuminate\Support\Carbon;

/**
 * Display helpers for raw API values (integer rupiah, ISO dates).
 */
class Format
{
    /**
     * 162000000 → "162.000.000".
     */
    public static function rupiah(int|float|null $amount): string
    {
        return number_format((float) ($amount ?? 0), 0, ',', '.');
    }

    /**
     * Compact amount: 900000 → "900rb", 1800000 → "1,8jt", 450000000 → "450jt".
     */
    public static function short(int|float|null $amount): string
    {
        $amount = (float) ($amount ?? 0);

        if ($amount >= 1_000_000_000) {
            return self::trim($amount / 1_000_000_000).'M';
        }

        if ($amount >= 1_000_000) {
            return self::trim($amount / 1_000_000).'jt';
        }

        if ($amount >= 1_000) {
            return self::trim($amount / 1_000).'rb';
        }

        return self::trim($amount);
    }

    public static function date(?string $value, string $format = 'D MMMM YYYY'): string
    {
        return $value ? self::carbon($value)->isoFormat($format) : '-';
    }

    public static function time(?string $value): string
    {
        return $value ? self::carbon($value)->format('H:i') : '-';
    }

    public static function carbon(string $value): CarbonInterface
    {
        return Carbon::parse($value)->timezone(config('app.timezone'))->locale('id');
    }

    public static function initials(?string $name): string
    {
        return collect(preg_split('/\s+/', trim((string) $name)))
            ->filter()
            ->take(2)
            ->map(fn ($part) => mb_strtoupper(mb_substr($part, 0, 1)))
            ->implode('');
    }

    private static function trim(float $value): string
    {
        return rtrim(rtrim(number_format($value, 1, ',', ''), '0'), ',');
    }
}
