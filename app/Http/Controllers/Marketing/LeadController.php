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

    /**
     * KTP is collected by the marketing the admin assigned the lead to.
     */
    public function uploadKtp(Request $request, ArkanaApi $api, int $id)
    {
        $request->validate(['file_ktp' => 'required|file|mimes:jpg,jpeg,png,pdf|max:5120']);

        $lead = $api->postMultipart("marketing/leads/{$id}/ktp", ['file_ktp' => $request->file('file_ktp')]);

        return back()->with('success', "KTP {$lead['nama_calon']} berhasil diunggah. Admin dapat memvalidasi lead ini.");
    }
}
