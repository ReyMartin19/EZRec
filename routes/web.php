<?php

use Illuminate\Support\Facades\Route;
use Laravel\Fortify\Features;
use App\Http\Controllers\AthleteController;

Route::inertia('/', 'Welcome', [
    'canRegister' => Features::enabled(Features::registration()),
])->name('home');

Route::middleware(['auth', 'verified'])->group(function () {
    Route::inertia('dashboard', 'Dashboard')->name('dashboard');
    Route::inertia('events', 'Events')->name('events');
    Route::get('athletes', [AthleteController::class, 'index'])->name('athletes.index');
    Route::inertia('athletes/create', 'Athletes/Create')->name('athletes.create');
    Route::post('athletes', [AthleteController::class, 'store'])->name('athletes.store');
    Route::inertia('coaches', 'Coaches')->name('coaches');
    Route::inertia('teams', 'Teams')->name('teams');
});

require __DIR__.'/settings.php';
