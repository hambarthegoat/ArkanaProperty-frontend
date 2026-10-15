<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Services\ArkanaApi;
use App\Support\Format;
use Illuminate\Http\Request;

class KavlingController extends Controller
{
    public function __construct(private ArkanaApi $api) {}

    /**
     * Loads every unit once and hands the grid a project → block → type
     * structure; filtering happens client-side like the original design.
     */
    public function index(Request $request)
    {
        $perumahan = $this->api->get('admin/perumahan');
        $kavling = $this->api->get('admin/kavling');
        $buyers = $this->api->get('admin/leads', ['status' => 'validated']);

        $projects = collect($perumahan)->map(fn ($p) => ['id' => $p['id'], 'name' => $p['nama_perumahan']])->values();

        $units = collect($kavling)->map(fn ($k) => [
            'id' => $k['id'],
            'code' => $k['nomor_kavling'],
            'project' => $k['tipe_rumah']['perumahan']['id'],
            'block' => $k['blok'] ?: 'Tanpa Blok',
            'type' => $k['tipe_rumah']['nama_tipe'],
            'price' => 'Rp '.Format::short($k['tipe_rumah']['harga']),
            'status' => $k['status'],
            'status_label' => $k['status_label'],
            'customer' => $k['leads']['nama_calon'] ?? null,
            'id_leads' => $k['leads']['id'] ?? null,
        ])->values();

        $blocks = $projects->mapWithKeys(fn ($p) => [
            $p['id'] => $units->where('project', $p['id'])->pluck('block')->unique()->sort()->values(),
        ]);

        $houseTypes = collect($perumahan)->mapWithKeys(fn ($p) => [
            $p['id'] => collect($p['tipe_rumah'])->pluck('nama_tipe')->values(),
        ]);

        $tipeOptions = collect($perumahan)->flatMap(fn ($p) => collect($p['tipe_rumah'])->map(fn ($t) => [
            'id' => $t['id'],
            'label' => $p['nama_perumahan'].' — '.$t['nama_tipe'],
        ]))->values();

        $counts = $units->countBy('status');

        return view('pages.admin.kavling', [
            'projects' => $projects,
            'blocks' => $blocks,
            'houseTypes' => $houseTypes,
            'kavlingData' => $units,
            'tipeOptions' => $tipeOptions,
            'buyers' => collect($buyers)->map(fn ($l) => ['id' => $l['id'], 'nama' => $l['nama_calon']])->values(),
            'initialProject' => (int) $request->query('perumahan', $projects->first()['id'] ?? 0),
            'statusTiles' => [
                ['value' => 'all', 'label' => 'Semua', 'count' => $units->count(), 'color' => 'bg-slate-200'],
                ['value' => 'tersedia', 'label' => 'Tersedia', 'count' => $counts['tersedia'] ?? 0, 'color' => 'bg-white border border-border-subtle'],
                ['value' => 'booking', 'label' => 'Booking', 'count' => $counts['booking'] ?? 0, 'color' => 'bg-accent'],
                ['value' => 'terjual', 'label' => 'Terjual', 'count' => $counts['terjual'] ?? 0, 'color' => 'bg-emerald-custom'],
            ],
        ]);
    }

    public function store(Request $request)
    {
        $request->validate(['id_tipe' => 'required|integer']);

        $kavling = $this->api->post("admin/tipe-rumah/{$request->integer('id_tipe')}/kavling", $request->only(['blok', 'nomor_kavling', 'status']));

        return redirect()->route('admin.kavling', ['perumahan' => $kavling['tipe_rumah']['perumahan']['id']])
            ->with('success', "Kavling {$kavling['nomor_kavling']} berhasil ditambahkan.");
    }

    public function update(Request $request, int $id)
    {
        $kavling = $this->api->put("admin/kavling/{$id}", [
            'status' => $request->input('status'),
            'id_leads' => $request->filled('id_leads') ? $request->integer('id_leads') : null,
        ]);

        return redirect()->route('admin.kavling', ['perumahan' => $kavling['tipe_rumah']['perumahan']['id']])
            ->with('success', "Status kavling {$kavling['nomor_kavling']} diperbarui menjadi {$kavling['status_label']}.");
    }
}
