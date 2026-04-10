<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\ManagerController;
use App\Http\Controllers\VoorraadController;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/manager/dashboard', [ManagerController::class, 'index'])->middleware(['auth', 'verified', 'role:manager'])->name('manager.dashboard');

Route::get('/dashboard', function () {
    if (auth()->user()->role === 'manager') {
        return redirect()->route('manager.dashboard');
    }

    // Medewerker, Vrijwilliger (en overige rollen) gaan naar het standaard dashboard.
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
    Route::get('/voorraad/overzicht', [VoorraadController::class, 'overzicht'])->name('voorraad.overzicht');
    Route::get('/voorraad/show/{name}', [VoorraadController::class, 'show'])->name('voorraad.show');
    // get edit page for voorraad
    Route::get('/voorraad/edit/{id}', [VoorraadController::class, 'edit'])->name('voorraad.edit');
    // update voorraad
    Route::post('/voorraad/update/{id}', [VoorraadController::class, 'update'])->name('voorraad.update');
});


require __DIR__ . '/auth.php';
