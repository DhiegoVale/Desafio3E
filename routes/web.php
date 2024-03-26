<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\MainController;

Route::get('/', [MainController::class, 'index']);

Route::get('/create', [MainController::class, 'create']);

Route::post('/assets/save', [MainController::class, 'store']);

Route::get('/assets/show', [MainController::class, 'show'])->name('assets.show');

Route::get('/assets/{id}/edit', [MainController::class, 'edit'])->where('id', '[0-9]+')->name('assets.edit');

Route::put('/assets/{id}/update', [MainController::class, 'update'])->where('id', '[0-9]+')->name('assets.update');

Route::delete('/assets/{id}/destroy', [MainController::class, 'destroy'])->where('id', '[0-9]+')->name('assets.destroy');

Route::get('/assets/filtrate', [MainController::class, 'filtrate']);

Route::get('/assets/search', [MainController::class, 'search']);

Route::middleware([
    'auth:sanctum',
    config('jetstream.auth_session'),
    'verified',
])->group(function () {
    Route::get('/dashboard', function () {
        return view('dashboard');
    })->name('dashboard');
});
