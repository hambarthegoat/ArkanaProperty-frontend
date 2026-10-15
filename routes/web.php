<?php

use App\Http\Controllers\Admin;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\LandingController;
use App\Http\Controllers\LeadController;
use App\Http\Controllers\PropertyController;
use Illuminate\Support\Facades\Route;

Route::get('/', [LandingController::class, 'index'])->name('home');
Route::get('/property/{id}', [PropertyController::class, 'show'])->whereNumber('id')->name('property.show');
Route::post('/leads', [LeadController::class, 'store'])->middleware('throttle:10,1')->name('leads.store');

Route::get('/login', [AuthController::class, 'show'])->name('login');
Route::post('/login', [AuthController::class, 'login'])->middleware('throttle:10,1')->name('login.attempt');
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

Route::prefix('admin')->name('admin.')->middleware('api.role:admin')->group(function () {
    Route::get('/', Admin\DashboardController::class)->name('dashboard');

    Route::get('/leads', [Admin\LeadsController::class, 'index'])->name('leads');
    Route::post('/leads/{id}/validate', [Admin\LeadsController::class, 'validateLead'])->name('leads.validate');
    Route::post('/leads/{id}/reject', [Admin\LeadsController::class, 'reject'])->name('leads.reject');
    Route::post('/leads/{id}/ktp', [Admin\LeadsController::class, 'uploadKtp'])->name('leads.ktp.upload');
    Route::get('/leads/{id}/ktp', [Admin\LeadsController::class, 'ktp'])->name('leads.ktp');

    Route::get('/kavling', [Admin\KavlingController::class, 'index'])->name('kavling');
    Route::post('/kavling', [Admin\KavlingController::class, 'store'])->name('kavling.store');
    Route::put('/kavling/{id}', [Admin\KavlingController::class, 'update'])->name('kavling.update');

    Route::get('/perumahan', [Admin\PerumahanController::class, 'index'])->name('perumahan');
    Route::post('/perumahan', [Admin\PerumahanController::class, 'store'])->name('perumahan.store');

    Route::get('/reports', [Admin\ReportController::class, 'index'])->name('reports');
    Route::get('/reports/export', [Admin\ReportController::class, 'export'])->name('reports.export');
});

Route::prefix('marketing')->name('marketing.')->middleware('api.role:marketing')->group(function () {
    Route::get('/', fn () => view('pages.marketing.dashboard'))->name('dashboard');
    Route::get('/calendar', fn () => view('pages.marketing.calendar'))->name('calendar');
    Route::get('/reports', fn () => view('pages.marketing.reports'))->name('reports');
});

Route::prefix('portal')->name('portal.')->middleware('api.role:leads')->group(function () {
    Route::get('/', fn () => view('pages.portal.dashboard'))->name('dashboard');
    Route::get('/reminders', fn () => view('pages.portal.timeline'))->name('reminders');
    Route::get('/support', fn () => view('pages.portal.support'))->name('support');
});
