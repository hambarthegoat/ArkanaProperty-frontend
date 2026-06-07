<?php

use Illuminate\Support\Facades\Route;

Route::get('/', fn () => view('pages.landing'))->name('home');
Route::get('/property/{id}', fn ($id) => view('pages.property-detail', ['id' => $id]))->name('property.show');

Route::get('/login', fn () => view('pages.login'))->name('login');

Route::prefix('admin')->name('admin.')->group(function () {
    Route::get('/', fn () => view('pages.admin.dashboard'))->name('dashboard');
    Route::get('/leads', fn () => view('pages.admin.leads'))->name('leads');
    Route::get('/kavling', fn () => view('pages.admin.kavling'))->name('kavling');
    Route::get('/perumahan', fn () => view('pages.admin.housing'))->name('perumahan');
    Route::get('/reports', fn () => view('pages.admin.marketing-reports'))->name('reports');
});

Route::prefix('marketing')->name('marketing.')->group(function () {
    Route::get('/', fn () => view('pages.marketing.dashboard'))->name('dashboard');
    Route::get('/calendar', fn () => view('pages.marketing.calendar'))->name('calendar');
    Route::get('/reports', fn () => view('pages.marketing.reports'))->name('reports');
});

Route::prefix('portal')->name('portal.')->group(function () {
    Route::get('/', fn () => view('pages.portal.dashboard'))->name('dashboard');
    Route::get('/reminders', fn () => view('pages.portal.timeline'))->name('reminders');
    Route::get('/support', fn () => view('pages.portal.support'))->name('support');
});
