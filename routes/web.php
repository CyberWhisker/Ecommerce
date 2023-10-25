<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\DashBoardController;
use App\Http\Controllers\Admin\UsersController;
use App\Http\Controllers\Admin\InventoryController;
use App\Http\Controllers\Admin\SettingController;
use App\Http\Controllers\Admin\SurveyController;
use App\Http\Controllers\Customer\CartController;
use App\Http\Controllers\Customer\DashboardController as CustomerDashboardController;
use App\Http\Controllers\StoreController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', [CustomerDashboardController::class, 'index'])->middleware('auth')->name('home');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

Route::prefix('admin')->middleware(['auth', 'isAdmin'])->group(function () {
    // Web links start here
    Route::get('dashboard', [DashBoardController::class, 'index'])->name('dashboard');
    Route::get('users', [UsersController::class, 'index'])->name('users');
    Route::get('inventory', [InventoryController::class, 'index'])->name('inventory');
    Route::get('survey', [SurveyController::class, 'index'])->name('survey');
    Route::get('setting', [SettingController::class, 'index'])->name('setting');
    
    //Function Users start here
    Route::post('storeUser', [UsersController::class, 'storeUser'])->name('storeUser');
    Route::post('editUser', [UsersController::class, 'editUser'])->name('editUser');
    Route::post('deleteUser', [UsersController::class, 'deleteUser'])->name('deleteUser');
    Route::post('/profile', [StoreController::class, 'createOrUpdateStore'])->name('profile.createOrUpdateStore');
    
    // Function Inventory start here
    Route::post('storeInventory', [InventoryController::class, 'storeInventory'])->name('storeInventory');
    Route::post('updateInventory', [InventoryController::class, 'updateInventory'])->name('updateInventory');
    Route::post('deleteInventory', [InventoryController::class, 'deleteInventory'])->name('deleteInventory');

    // Function Survey start here
    Route::post('storeSurvey', [SurveyController::class, 'storeSurvey'])->name('storeSurvey');
    Route::post('updateSurvey', [SurveyController::class, 'updateSurvey'])->name('updateSurvey');
    Route::post('deleteSurvey', [SurveyController::class, 'deleteSurvey'])->name('deleteSurvey');

    // Setting Function Start Here
    Route::post('storeUnit', [SettingController::class, 'storeUnit'])->name('storeUnit');
    Route::post('updateUnit', [SettingController::class, 'updateUnit'])->name('updateUnit');
    Route::post('deleteUnit', [SettingController::class, 'deleteUnit'])->name('deleteUnit');
});

Route::prefix('customer')->middleware(['auth',])->group(function () {
    // Web links start here
    Route::get('cart', [CartController::class, 'index'])->name('cart');


    // Cart Function Start Here
    Route::post('storeCart', [CartController::class, 'storeCart'])->name('storeCart');
    Route::post('updateUnit', [CartController::class, 'updateUnit'])->name('updateUnit');
    Route::post('deleteUnit', [CartController::class, 'deleteUnit'])->name('deleteUnit');
});
require __DIR__.'/auth.php';
