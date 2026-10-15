<?php

namespace App\Http\Controllers\Marketing;

use App\Http\Controllers\Controller;
use App\Services\ArkanaApi;
use Illuminate\Http\Request;

class LeadController extends Controller
{
    public function update(Request $request, ArkanaApi $api, int $id)
    {
        $lead = $api->patch("marketing/leads/{$id}", [
            'prioritas' => $request->input('prioritas') ?: null,
            'catatan' => $request->input('catatan'),
        ]);

        return back()->with('success', "Catatan untuk {$lead['nama_calon']} disimpan.");
    }
}
