<?php

use Illuminate\Support\Facades\Route;
use Laravel\Fortify\Features;
use App\Http\Controllers\AthleteController;
use App\Http\Controllers\EventController;
use App\Http\Controllers\CoachController;

Route::inertia('/', 'Welcome', [
    'canRegister' => Features::enabled(Features::registration()),
])->name('home');

Route::middleware(['auth', 'verified'])->group(function () {
    Route::inertia('dashboard', 'Dashboard')->name('dashboard');

    Route::get('events', [EventController::class, 'index'])->name('events');
    Route::post('events', [EventController::class, 'store'])->name('events.store');
    Route::put('events/{event}', [EventController::class, 'update'])->name('events.update');
    
    Route::get('athletes', [AthleteController::class, 'index'])->name('athletes.index');
    Route::post('athletes', [AthleteController::class, 'store'])->name('athletes.store');
    Route::put('athletes/{athlete}', [AthleteController::class, 'update'])->name('athletes.update');

    Route::get('coaches', [CoachController::class, 'index'])->name('coaches');
    Route::post('coaches', [CoachController::class, 'store'])->name('coaches.store');
    Route::put('coaches/{coach}', [CoachController::class, 'update'])->name('coaches.update');

    Route::inertia('teams', 'Teams')->name('teams');
});

require __DIR__.'/settings.php';
