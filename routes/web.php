<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\VoedselpakketController;
use App\Http\Controllers\ManagerController;

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
});

// voedselpakketten routes
Route::get('/vrijwilliger/voedselpakketten', [VoedselpakketController::class, 'index'])->middleware(['auth', 'verified', 'role:manager,vrijwilliger'])->name('voedselpakket.index');
Route::get('/vrijwilliger/show/{id}', [VoedselpakketController::class, 'show'])->middleware(['auth', 'verified', 'role:manager,vrijwilliger'])->name('voedselpakket.show');
Route::get('/vrijwilliger/edit/{id}', [VoedselpakketController::class, 'edit'])->middleware(['auth', 'verified', 'role:manager,vrijwilliger'])->name('voedselpakket.edit');
Route::put('/vrijwilliger/update/{id}', [VoedselpakketController::class, 'update'])->middleware(['auth', 'verified', 'role:manager,vrijwilliger'])->name('voedselpakket.update');


require __DIR__.'/auth.php';
