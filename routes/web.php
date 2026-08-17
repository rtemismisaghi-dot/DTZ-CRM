<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\CustomerController;
use App\Http\Controllers\MeasurementController;
use App\Http\Controllers\InstallationController;

use App\Http\Controllers\Tablet\TabletController;
use App\Http\Controllers\TabletPlanController;

// ==========================
// Welcome
// ==========================

Route::get('/', function () {
    return view('welcome');
});


// ==========================
// Authenticated Routes
// ==========================

Route::middleware(['auth'])->group(function () {


    // Dashboard

    Route::get('/dashboard', [DashboardController::class, 'index'])
        ->name('dashboard');


    // Customers

    Route::resource('customers', CustomerController::class);



    // Measurements

    Route::get('/measurements', [MeasurementController::class, 'index'])
        ->name('measurements.index');

    Route::get('/measurements/create', [MeasurementController::class, 'create'])
        ->name('measurements.create');

    Route::post('/measurements', [MeasurementController::class, 'store'])
        ->name('measurements.store');

    Route::get('/measurements/{measurement}', [MeasurementController::class, 'show'])
        ->name('measurements.show');

    Route::get('/measurements/{measurement}/edit', [MeasurementController::class, 'edit'])
        ->name('measurements.edit');

    Route::put('/measurements/{measurement}', [MeasurementController::class, 'update'])
        ->name('measurements.update');

    Route::delete('/measurements/{measurement}', [MeasurementController::class, 'destroy'])
        ->name('measurements.destroy');

    Route::post('/measurements/search-customer', [MeasurementController::class, 'searchCustomer'])
        ->name('measurements.searchCustomer');



    // Installations

    Route::get('/installations', [InstallationController::class, 'index'])
        ->name('installations.index');

    Route::get('/installations/create', [InstallationController::class, 'create'])
        ->name('installations.create');

    Route::post('/installations', [InstallationController::class, 'store'])
        ->name('installations.store');

    Route::get('/installations/{installation}', [InstallationController::class, 'show'])
        ->name('installations.show');

    Route::get('/installations/{installation}/prepare',
        [InstallationController::class, 'prepare'])
        ->name('installations.prepare');

    Route::get('/installations/{installation}/edit',
        [InstallationController::class, 'edit'])
        ->name('installations.edit');

    Route::put('/installations/{installation}',
        [InstallationController::class, 'update'])
        ->name('installations.update');

    Route::delete('/installations/{installation}',
        [InstallationController::class, 'destroy'])
        ->name('installations.destroy');

    Route::post('/installations/search-customer',
        [InstallationController::class, 'searchCustomer'])
        ->name('installations.searchCustomer');



    // Profile

    Route::get('/profile', [ProfileController::class, 'edit'])
        ->name('profile.edit');

    Route::patch('/profile', [ProfileController::class, 'update'])
        ->name('profile.update');

    Route::delete('/profile', [ProfileController::class, 'destroy'])
        ->name('profile.destroy');


});



// ==========================
// Admin Installation Items
// ==========================

Route::prefix('admin')
    ->middleware(['auth'])
    ->group(function(){


    Route::resource(
        'installation-items',
        \App\Http\Controllers\Admin\InstallationItemController::class
    );


});



// ==========================
// Admin Settings
// ==========================

Route::get('/admin/settings', function(){

    return view('admin.settings.index');

})->name('admin.settings');



// ==========================
// Auth
// ==========================
Route::delete('/dtztablet/space/{space}',
    [\App\Http\Controllers\TabletPlanController::class, 'destroy'])
    ->name('tablet.space.destroy');
require __DIR__.'/auth.php';


// ==========================
// DTZ Tablet
// ==========================

Route::get('/dtztablet', [TabletController::class, 'index'])
    ->name('tablet.index');


Route::get('/dtztablet/plan',
    [TabletPlanController::class, 'index'])
    ->name('tablet.plan');


Route::get('/dtztablet/space/create',
    [TabletPlanController::class, 'create'])
    ->name('tablet.space.create');


Route::post('/dtztablet/space/store',
    [TabletPlanController::class, 'storeSpace'])
    ->name('tablet.space.store');


Route::delete('/dtztablet/space/{space}',
    [TabletPlanController::class, 'destroy'])
    ->name('tablet.space.destroy');


Route::post(
    '/tablet/space/analyze-image',
    [TabletController::class, 'analyzeSpaceImage']
)->name('tablet.space.analyze-image');