<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\VoedselpakketController;
use App\Http\Controllers\ManagerController;
use App\Http\Controllers\VoorraadController;
use App\Http\Controllers\LeverancierController;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/manager/dashboard', [ManagerController::class, 'index'])->middleware(['auth', 'verified', 'role:manager'])->name('manager.dashboard');
use App\Http\Controllers\AllergieController;

Route::get('/manager/overzicht-allergieen', [AllergieController::class, 'overzicht'])
    ->middleware(['auth', 'verified', 'role:manager'])
    ->name('overzicht_allergieen');

Route::get('/manager/allergieen-detail/{gezin_id}', [AllergieController::class, 'detail'])
    ->middleware(['auth', 'verified', 'role:manager'])
    ->name('allergieen_detail');

Route::get('/manager/allergieen-edit/{persoon_id}', [AllergieController::class, 'edit'])
    ->middleware(['auth', 'verified', 'role:manager'])
    ->name('allergieen_edit');

Route::post('/manager/allergieen-update/{persoon_id}', [AllergieController::class, 'update'])
    ->middleware(['auth', 'verified', 'role:manager'])
    ->name('allergieen_update');

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
    Route::match(['put', 'post'], '/voorraad/update/{id}', [VoorraadController::class, 'update'])->name('voorraad.update');
    
    // Leverancier routes - only for manager and medewerker
    Route::get('/leverancier', [LeverancierController::class, 'index'])
        ->middleware('role:manager,medewerker')
        ->name('leverancier.index');
    Route::get('/leverancier/{id}/products', [LeverancierController::class, 'products'])
        ->middleware('role:manager,medewerker')
        ->name('leverancier.products');
    Route::get('/leverancier/{leverancierId}/product/{productId}/edit', [LeverancierController::class, 'editProduct'])
        ->middleware('role:manager')
        ->name('leverancier.product.edit');
    Route::post('/leverancier/{leverancierId}/product/{productId}/update', [LeverancierController::class, 'updateProduct'])
        ->middleware('role:manager')
        ->name('leverancier.product.update');
});

// voedselpakketten routes
Route::get('/vrijwilliger/voedselpakketten', [VoedselpakketController::class, 'index'])->middleware(['auth', 'verified', 'role:manager,vrijwilliger'])->name('voedselpakket.index');
Route::get('/vrijwilliger/show/{id}', [VoedselpakketController::class, 'show'])->middleware(['auth', 'verified', 'role:manager,vrijwilliger'])->name('voedselpakket.show');
Route::get('/vrijwilliger/edit/{id}', [VoedselpakketController::class, 'edit'])->middleware(['auth', 'verified', 'role:manager,vrijwilliger'])->name('voedselpakket.edit');
Route::put('/vrijwilliger/update/{id}', [VoedselpakketController::class, 'update'])->middleware(['auth', 'verified', 'role:manager,vrijwilliger'])->name('voedselpakket.update');


require __DIR__ . '/auth.php';
