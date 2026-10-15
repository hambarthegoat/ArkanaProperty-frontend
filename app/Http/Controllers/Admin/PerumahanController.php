<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Services\ArkanaApi;
use Illuminate\Http\Request;

class PerumahanController extends Controller
{
    public function __construct(private ArkanaApi $api) {}

    public function index()
    {
        return view('pages.admin.housing', ['projects' => $this->api->get('admin/perumahan')]);
    }

    /**
     * New project with an optional first house type; more types and units
     * are added from the kavling page or the admin panel.
     */
    public function store(Request $request)
    {
        $request->validate(['gambar' => 'nullable|image|max:5120']);

        $tipe = array_filter($request->input('tipe', []), fn ($value) => filled($value));

        $perumahan = $this->api->postMultipart('admin/perumahan', [
            'nama_perumahan' => $request->input('nama_perumahan'),
            'lokasi' => $request->input('lokasi'),
            'deskripsi' => $request->input('deskripsi'),
            'status' => $request->input('status'),
            'gambar' => $request->file('gambar'),
            'tipe_rumah' => $tipe ? [$tipe] : null,
        ]);

        return redirect()->route('admin.perumahan')->with('success', "Perumahan {$perumahan['nama_perumahan']} berhasil ditambahkan.");
    }
}
