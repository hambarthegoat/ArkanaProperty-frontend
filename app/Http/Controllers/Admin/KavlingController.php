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
            'house' => $k['nomor_rumah'] ?? null,
            'label' => $k['label'] ?? $k['nomor_kavling'],
            'project' => $k['tipe_rumah']['perumahan']['id'],
            'block' => $k['blok'] ?: 'Tanpa Blok',
            'type' => $k['tipe_rumah']['nama_tipe'],
            'price' => 'Rp '.Format::short($k['tipe_rumah']['harga']),
            'status' => $k['status'],
            'status_label' => $k['status_label'],
            'customer' => $k['leads']['nama_calon'] ?? null,
            'id_leads' => $k['leads']['id'] ?? null,
        ])->values();

        // Blocks come from the API (so empty ones show up) plus any block
        // name still carried only by houses.
        $blockMeta = collect($perumahan)->mapWithKeys(fn ($p) => [
            $p['id'] => collect($p['blok'] ?? [])->mapWithKeys(fn ($b) => [
                $b['nama'] => ['id' => $b['id'], 'count' => $b['jumlah_rumah'] ?? 0],
            ]),
        ]);

        $blocks = $projects->mapWithKeys(fn ($p) => [
            $p['id'] => $units->where('project', $p['id'])->pluck('block')
                ->merge($blockMeta[$p['id']]->keys())->unique()->sort()->values(),
        ]);

        $blockOptions = $blockMeta->map(fn ($meta) => $meta->keys()->sort()->values());

        $houseTypes = collect($perumahan)->mapWithKeys(fn ($p) => [
            $p['id'] => collect($p['tipe_rumah'])->pluck('nama_tipe')->values(),
        ]);

        $tipeOptions = collect($perumahan)->flatMap(fn ($p) => collect($p['tipe_rumah'])->map(fn ($t) => [
            'id' => $t['id'],
            'project' => $p['id'],
            'label' => $p['nama_perumahan'].' — '.$t['nama_tipe'],
        ]))->values();

        $counts = $units->countBy('status');

        $initialProject = (int) $request->query('perumahan', $projects->first()['id'] ?? 0);

        return view('pages.admin.kavling', [
            'projects' => $projects,
            'blocks' => $blocks,
            'blockMeta' => $blockMeta,
            'blockOptions' => $blockOptions,
            'houseTypes' => $houseTypes,
            'kavlingData' => $units,
            'tipeOptions' => $tipeOptions,
            'defaultTipe' => $tipeOptions->firstWhere('project', $initialProject)['id'] ?? null,
            'buyers' => collect($buyers)->map(fn ($l) => ['id' => $l['id'], 'nama' => $l['nama_calon']])->values(),
            'initialProject' => $initialProject,
            'statusTiles' => [
                ['value' => 'all', 'label' => 'Semua', 'count' => $units->count(), 'color' => 'bg-slate-200'],
                ['value' => 'tersedia', 'label' => 'Tersedia', 'count' => $counts['tersedia'] ?? 0, 'color' => 'bg-white border border-border-subtle'],
                ['value' => 'booking', 'label' => 'Booking', 'count' => $counts['booking'] ?? 0, 'color' => 'bg-accent'],
                ['value' => 'terjual', 'label' => 'Terjual', 'count' => $counts['terjual'] ?? 0, 'color' => 'bg-emerald-custom'],
            ],
        ]);
    }

    /**
     * Creates an empty block in a project; houses are added to it after.
     */
    public function storeBlok(Request $request)
    {
        $request->validate([
            'id_perumahan' => 'required|integer',
            'nama' => 'required|string|max:50',
        ]);

        $blok = $this->api->post("admin/perumahan/{$request->integer('id_perumahan')}/blok", ['nama' => $request->input('nama')]);

        return redirect()->route('admin.kavling', ['perumahan' => $blok['id_perumahan']])
            ->with('success', "{$blok['nama']} berhasil dibuat. Tambahkan rumah ke blok ini.");
    }

    /**
     * Only empty blocks can be removed; the API refuses the rest.
     */
    public function destroyBlok(Request $request, int $id)
    {
        $this->api->delete("admin/blok/{$id}");

        return redirect()->route('admin.kavling', array_filter(['perumahan' => $request->input('perumahan')]))
            ->with('success', 'Blok berhasil dihapus.');
    }

    public function store(Request $request)
    {
        $request->validate(['id_tipe' => 'required|integer']);

        $request->validate(['jumlah_rumah' => 'nullable|integer|min:1|max:20']);

        $payload = $request->only(['blok', 'nomor_kavling', 'status']);

        if ($request->filled('jumlah_rumah')) {
            $payload['jumlah_rumah'] = $request->integer('jumlah_rumah');
        }

        $kavling = $this->api->post("admin/tipe-rumah/{$request->integer('id_tipe')}/kavling", $payload);
        $dibuat = $kavling['jumlah_dibuat'] ?? 1;

        return redirect()->route('admin.kavling', ['perumahan' => $kavling['tipe_rumah']['perumahan']['id']])
            ->with('success', $dibuat > 1
                ? "{$dibuat} rumah berhasil ditambahkan pada kavling {$kavling['nomor_kavling']}."
                : "Kavling {$kavling['nomor_kavling']} berhasil ditambahkan.");
    }

    public function update(Request $request, int $id)
    {
        $kavling = $this->api->put("admin/kavling/{$id}", [
            'status' => $request->input('status'),
            'id_leads' => $request->filled('id_leads') ? $request->integer('id_leads') : null,
        ]);

        return redirect()->route('admin.kavling', ['perumahan' => $kavling['tipe_rumah']['perumahan']['id']])
            ->with('success', 'Status kavling '.($kavling['label'] ?? $kavling['nomor_kavling'])." diperbarui menjadi {$kavling['status_label']}.");
    }
}
