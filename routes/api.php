<?php

use App\Http\Controllers\Api\PalazInstallationController;
use Illuminate\Support\Facades\Route;

Route::middleware('throttle:60,1')->post(
    '/palaz/installations',
    [PalazInstallationController::class, 'store']
)->name('api.palaz.installations.store');
