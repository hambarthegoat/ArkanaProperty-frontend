<?php

namespace App\Support;

/**
 * New leads nobody has picked up yet (pending, no marketing). Marketing
 * claims one by uploading its KTP; only claimed leads are "own" leads.
 */
class LeadQueue
{
    public static function isQueued(array $lead): bool
    {
        return ($lead['status_keseriusan'] ?? null) === 'pending' && ($lead['id_marketing'] ?? null) === null;
    }
}
