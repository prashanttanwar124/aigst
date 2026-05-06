<?php

use Illuminate\Support\Facades\Route;
use Laravel\Fortify\Features;

Route::inertia('/', 'Welcome', [
    'canRegister' => Features::enabled(Features::registration()),
])->name('home');

Route::inertia('/menu', 'Menu')->name('menu');
Route::inertia('/catering', 'Catering')->name('catering');
Route::inertia('/party-trays', 'PartyTrays')->name('party-trays');
Route::inertia('/contact', 'Contact')->name('contact');

Route::get('/sitemap.xml', function () {
    $pages = collect([
        route('home'),
        route('menu'),
        route('catering'),
        route('party-trays'),
        route('contact'),
    ]);

    return response()->view('sitemap', [
        'pages' => $pages,
        'lastModified' => now()->toDateString(),
    ])->header('Content-Type', 'application/xml');
})->name('sitemap');

Route::middleware(['auth', 'verified'])->group(function () {
    Route::inertia('dashboard', 'Dashboard')->name('dashboard');
});

require __DIR__.'/settings.php';
