<?php

use App\Http\Controllers\Api\PalazInstallationController;
use Illuminate\Support\Facades\Route;

Route::middleware('throttle:60,1')->post(
    '/palaz/installations',
    [PalazInstallationController::class, 'store']
)->name('api.palaz.installations.store');

Route::middleware('throttle:60,1')->get(
    '/palaz/installations/{installation}/quote',
    [PalazInstallationController::class, 'quote']
)->name('api.palaz.installations.quote');

Route::middleware('throttle:60,1')->post(
    '/palaz/installations/{installation}/complete',
    [PalazInstallationController::class, 'completeApi']
)->name('api.palaz.installations.complete');
