<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\DashBoardController;
use App\Http\Controllers\Admin\UsersController;
use App\Http\Controllers\Admin\InventoryController;
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

Route::get('/', function () {
    return view('dashboard');
})->middleware('auth')->name('home');

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
    //Function start here
    Route::post('storeUser', [UsersController::class, 'storeUser'])->name('storeUser');
    Route::post('updateRole', [UsersController::class, 'updateRole'])->name('updateRole');
    Route::post('/profile', [StoreController::class, 'createOrUpdateStore'])->name('profile.createOrUpdateStore');
});

require __DIR__.'/auth.php';
