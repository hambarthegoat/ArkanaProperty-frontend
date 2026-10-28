<?php

namespace App\Http\Controllers;

use App\Services\ArkanaApi;
use Illuminate\Http\Request;

class LeadController extends Controller
{
    public function __construct(private ArkanaApi $api) {}

    /**
     * Interest form from the landing modal and the property page. The API
     * validates the payload; its 422 errors come back as form errors. KTP is
     * not collected here: marketing uploads it later.
     */
    public function store(Request $request)
    {
        $request->validate([
            'id_tipe' => 'required|integer',
        ]);

        $this->api->post('public/leads', [
            'id_tipe' => $request->input('id_tipe'),
            'nama_calon' => $request->input('nama_calon'),
            'no_telp' => $request->input('no_telp'),
            'pesan' => $request->input('pesan'),
        ]);

        return back()->with('lead_success', [
            'id_tipe' => (int) $request->input('id_tipe'),
            'nama' => $request->input('nama_calon'),
        ]);
    }
}
