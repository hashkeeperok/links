<?php

use App\Http\Controllers\API\LinkController;
use App\Http\Controllers\API\StatisticController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

/**
 * Ссылки
 */
Route::prefix('links')->group(function () {
    Route::get('/', [LinkController::class, 'index'])->name('api.links.index');
    Route::post('/', [LinkController::class, 'store'])->name('api.links.store');

    Route::get('/{link}', [LinkController::class, 'show'])->name('api.links.show');
    Route::patch('/{link}', [LinkController::class, 'update'])->name('api.links.update');
    Route::delete('/{link}', [LinkController::class, 'destroy'])->name('api.links.destroy');
});

/**
 * Статистика
 */
Route::prefix('stats')->group(function () {
    Route::get('/', [StatisticController::class, 'index'])->name('api.stats.link');
    Route::get('/{link}', [StatisticController::class, 'link'])->name('api.stats.link');
});
