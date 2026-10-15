<?php

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
    Route::get('/', fn () => view('pages.admin.dashboard'))->name('dashboard');
    Route::get('/leads', fn () => view('pages.admin.leads'))->name('leads');
    Route::get('/kavling', fn () => view('pages.admin.kavling'))->name('kavling');
    Route::get('/perumahan', fn () => view('pages.admin.housing'))->name('perumahan');
    Route::get('/reports', fn () => view('pages.admin.marketing-reports'))->name('reports');
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
