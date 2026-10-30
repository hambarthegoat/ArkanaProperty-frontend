<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Services\ArkanaApi;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;

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

        // The jenis_rumah select always has a value, so only the other fields
        // tell whether a first house type was actually filled in.
        $tipe = array_filter(Arr::except($request->input('tipe', []), 'jenis_rumah'), fn ($value) => filled($value));

        if ($tipe) {
            $tipe['jenis_rumah'] = $request->input('tipe.jenis_rumah');
        }

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

    /**
     * Edit project details; the image is replaced only when a file is sent.
     * Multipart goes as POST with _method=PUT because PHP ignores PUT bodies.
     */
    public function update(Request $request, int $id)
    {
        $request->validate(['gambar' => 'nullable|image|max:5120']);

        $perumahan = $this->api->postMultipart("admin/perumahan/{$id}", [
            '_method' => 'PUT',
            'nama_perumahan' => $request->input('nama_perumahan'),
            'lokasi' => $request->input('lokasi'),
            'deskripsi' => $request->input('deskripsi') ?? '',
            'status' => $request->input('status'),
            'gambar' => $request->file('gambar'),
        ]);

        return redirect()->route('admin.perumahan')->with('success', "Perumahan {$perumahan['nama_perumahan']} berhasil diperbarui.");
    }

    /**
     * The API refuses projects that still have leads or booked/sold units;
     * that message comes back as a form error.
     */
    public function destroy(int $id)
    {
        $this->api->delete("admin/perumahan/{$id}");

        return redirect()->route('admin.perumahan')->with('success', 'Perumahan berhasil dihapus.');
    }
}
