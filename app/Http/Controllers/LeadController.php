<?php

namespace App\Http\Controllers;

use App\Services\ArkanaApi;
use Illuminate\Http\Request;

class LeadController extends Controller
{
    public function __construct(private ArkanaApi $api) {}

    /**
     * Interest form from the landing modal and the property page. The API
     * validates the payload; its 422 errors come back as form errors.
     */
    public function store(Request $request)
    {
        $request->validate([
            'id_tipe' => 'required|integer',
            'file_ktp' => 'nullable|file|mimes:jpg,jpeg,png,pdf|max:5120',
        ]);

        $this->api->postMultipart('public/leads', [
            'id_tipe' => $request->input('id_tipe'),
            'nama_calon' => $request->input('nama_calon'),
            'no_telp' => $request->input('no_telp'),
            'pesan' => $request->input('pesan'),
            'file_ktp' => $request->file('file_ktp'),
        ]);

        return back()->with('lead_success', [
            'id_tipe' => (int) $request->input('id_tipe'),
            'nama' => $request->input('nama_calon'),
        ]);
    }
}
