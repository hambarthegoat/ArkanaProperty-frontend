<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Services\ArkanaApi;
use Illuminate\Http\Request;

class LeadsController extends Controller
{
    public function __construct(private ArkanaApi $api) {}

    public function index(Request $request)
    {
        $filters = $request->only(['status', 'search']);

        return view('pages.admin.leads', [
            'leads' => $this->api->get('admin/leads', $filters),
            'stats' => $this->api->get('admin/dashboard')['leads'],
            'marketing' => $this->api->get('admin/marketing'),
            'filters' => $filters,
        ]);
    }

    public function validateLead(Request $request, int $id)
    {
        $request->validate(['id_marketing' => 'nullable|integer']);

        $result = $this->api->post("admin/leads/{$id}/validate", array_filter([
            'is_valid' => true,
            'id_marketing' => $request->filled('id_marketing') ? (int) $request->input('id_marketing') : null,
        ], fn ($value) => $value !== null));

        $kredensial = $result['kredensial'];
        $message = "Lead {$result['lead']['nama_calon']} tervalidasi dan ditugaskan ke {$result['lead']['marketing']['nama']}.";
        $message .= $kredensial['akun_baru']
            ? "\nAkun portal konsumen: username {$kredensial['username']} / password {$kredensial['password']} (hanya ditampilkan sekali, kirimkan ke konsumen)."
            : "\nLead dihubungkan ke akun portal yang sudah ada ({$kredensial['username']}).";

        return back()->with('success', $message);
    }

    public function reject(int $id)
    {
        $lead = $this->api->post("admin/leads/{$id}/validate", ['is_valid' => false]);

        return back()->with('success', "Lead {$lead['nama_calon']} ditolak.");
    }

    /**
     * Streams the private KTP file through the frontend so the admin never
     * needs the API token in the browser.
     */
    public function ktp(int $id)
    {
        $response = $this->api->download("admin/leads/{$id}/ktp");

        return response($response->body(), 200, [
            'Content-Type' => $response->header('Content-Type') ?: 'application/octet-stream',
            'Content-Disposition' => 'inline; filename="ktp-'.$id.'"',
            'Cache-Control' => 'private, no-store',
        ]);
    }
}
