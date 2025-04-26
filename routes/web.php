<?php

use Inertia\Inertia;
use App\Notifications\SmsMessage;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\SaleController;
use App\Http\Controllers\StockController;
use App\Http\Controllers\ImagesController;
use App\Http\Controllers\CustomerController;
use App\Http\Controllers\MedicineController;
use App\Http\Controllers\PurchaseController;
// use App\Http\Controllers\Auth\ProfileController;
use App\Http\Controllers\ManufacturerController;


Route::redirect('/', '/dashboard')->name('home');

Route::middleware('auth')->group(function (): void {

    // Default route
    Route::get('/dashboard', function () {
        return Inertia::render('Dashboard');
    })->name('dashboard');
    // Default route
    Route::get('/about', function () {
        return Inertia::render('About');
    })->name('about');

    Route::get('/sms', function (): void {
        // Or send a sms directly
        $sms = new SmsMessage;
        // Replace with your telephone number :-)
        $sms->to('+8801719454658')->line('Hello World.')->line('Open.')->send();
    });


    // Profile management
    // Route::controller(ProfileController::class)->group(function (): void {
    //     Route::get('profile', 'index')->name('profile');
    //     Route::get('profile/edit', 'create')->name('profile.edit');
    //     Route::put('profile/update', 'update')->name('profile.update');
    // });


    // Resources
    Route::resource('stocks', StockController::class);
    Route::resource('customers', CustomerController::class);
    Route::post('medicines/import', [MedicineController::class, 'importMedicines'])->name('medicines.import');
    Route::get('medicines/export', [MedicineController::class, 'exportMedicines'])->name('medicines.export');
    Route::resource('medicines', MedicineController::class);
    Route::get('list-of-medicines', [PurchaseController::class, 'searchMedicine'])->name('purchases.medicine');
    Route::resource('purchases', PurchaseController::class);
    Route::get('list-of-medicines-with-batch', [SaleController::class, 'searchMedicine'])->name('sales.medicine');
    Route::resource('sales', SaleController::class);
    Route::post('manufacturers/import', [ManufacturerController::class, 'importManufacturers'])->name('manufacturers.import');
    Route::get('manufacturers/export', [ManufacturerController::class, 'exportManufacturers'])->name('manufacturers.export');
    Route::resource('manufacturers', ManufacturerController::class);
});


// Images
Route::get('/storage/{path}', [ImagesController::class, 'show'])
    ->where('path', '.*')
    ->name('storage');

require __DIR__ . '/settings.php';
require __DIR__ . '/auth.php';
