<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Services\ArkanaApi;

class DashboardController extends Controller
{
    public function __invoke(ArkanaApi $api)
    {
        return view('pages.admin.dashboard', ['summary' => $api->get('admin/dashboard')]);
    }
}
