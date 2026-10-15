<?php

namespace App\Support;

/**
 * Tailwind badge classes for the enum values the API sends.
 */
class Badge
{
    public static function leadStatus(?string $status): string
    {
        return match ($status) {
            'pending' => 'bg-orange-100 text-orange-600',
            'validated' => 'bg-emerald-100 text-emerald-600',
            'rejected' => 'bg-red-100 text-red-600',
            default => 'bg-slate-100 text-slate-500',
        };
    }

    public static function priority(?string $priority): string
    {
        return match ($priority) {
            'tinggi' => 'bg-red-100 text-red-600',
            'sedang' => 'bg-orange-100 text-orange-600',
            'rendah' => 'bg-slate-100 text-slate-500',
            default => 'bg-slate-100 text-slate-400',
        };
    }

    public static function agenda(?string $jenis): string
    {
        return match ($jenis) {
            'closing' => 'bg-emerald-100 text-emerald-600',
            'survey' => 'bg-blue-100 text-blue-600',
            'follow_up' => 'bg-orange-100 text-orange-600',
            default => 'bg-slate-100 text-slate-500',
        };
    }

    public static function activity(?string $activity): string
    {
        return match ($activity) {
            'closing', 'booking' => 'bg-emerald-50 text-emerald-600',
            'survey_lokasi' => 'bg-blue-50 text-blue-600',
            'follow_up', 'penawaran' => 'bg-orange-50 text-orange-600',
            default => 'bg-slate-50 text-slate-500',
        };
    }
}
