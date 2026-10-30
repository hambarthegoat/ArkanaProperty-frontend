<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Services\ArkanaApi;
use Illuminate\Http\Request;

class MarketingController extends Controller
{
    public function __construct(private ArkanaApi $api) {}

    public function index()
    {
        return view('pages.admin.marketing', ['accounts' => $this->api->get('admin/marketing')]);
    }

    /**
     * Creates a marketing account. The API validates it; its 422 errors
     * (taken username, short password) come back as form errors.
     */
    public function store(Request $request)
    {
        $request->validate([
            'username' => 'required|string|max:255',
            'password' => 'required|string|min:6',
        ]);

        $akun = $this->api->post('admin/marketing', [
            'username' => $request->input('username'),
            'password' => $request->input('password'),
            'nama' => $request->input('nama'),
            'no_telp' => $request->input('no_telp'),
        ]);

        return redirect()->route('admin.marketing')->with('success', "Akun marketing {$akun['username']} berhasil dibuat. Berikan username dan password ke yang bersangkutan.");
    }
}
