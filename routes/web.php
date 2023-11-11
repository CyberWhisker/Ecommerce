<?php

use App\Http\Controllers\Admin\CalendarController;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\DashBoardController;
use App\Http\Controllers\Admin\UsersController;
use App\Http\Controllers\Admin\InventoryController;
use App\Http\Controllers\Admin\OrderController as AdminOrderController;
use App\Http\Controllers\Admin\SettingController;
use App\Http\Controllers\Admin\SurveyController;
use App\Http\Controllers\Customer\CartController;
use App\Http\Controllers\Customer\DashboardController as CustomerDashboardController;
use App\Http\Controllers\Customer\OrderController;
use App\Http\Controllers\PaymentController;
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
    Route::get('admin.order', [AdminOrderController::class, 'index'])->name('admin.order');
    Route::get('calendar', [CalendarController::class, 'index'])->name('calendar');
    Route::get('admin.delivery', [AdminOrderController::class, 'indexDelivery'])->name('admin.delivery');

    //Function Users start here
    Route::post('searchUser', [UsersController::class, 'searchUser'])->name('searchUser');
    Route::post('storeUser', [UsersController::class, 'storeUser'])->name('storeUser');
    Route::post('editUser', [UsersController::class, 'editUser'])->name('editUser');
    Route::post('deleteUser', [UsersController::class, 'deleteUser'])->name('deleteUser');
    Route::post('/profile', [StoreController::class, 'createOrUpdateStore'])->name('profile.createOrUpdateStore');

    // Function Inventory start here
    Route::post('searchInventory', [InventoryController::class, 'searchInventory'])->name('searchInventory');
    Route::post('storeInventory', [InventoryController::class, 'storeInventory'])->name('storeInventory');
    Route::post('updateInventory', [InventoryController::class, 'updateInventory'])->name('updateInventory');
    Route::post('deleteInventory', [InventoryController::class, 'deleteInventory'])->name('deleteInventory');

    // Function Survey start here
    Route::post('searchSurvey', [SurveyController::class, 'searchSurvey'])->name('searchSurvey');
    Route::post('storeSurvey', [SurveyController::class, 'storeSurvey'])->name('storeSurvey');
    Route::post('updateSurvey', [SurveyController::class, 'updateSurvey'])->name('updateSurvey');
    Route::post('deleteSurvey', [SurveyController::class, 'deleteSurvey'])->name('deleteSurvey');

    // Function Order start here
    Route::post('updateOrderStatus', [AdminOrderController::class, 'updateOrderStatus'])->name('updateOrderStatus');
    Route::post('updateOrderDelivery', [AdminOrderController::class, 'updateOrderDelivery'])->name('updateOrderDelivery');
    Route::post('udpateOrderRecieve', [AdminOrderController::class, 'udpateOrderRecieve'])->name('udpateOrderRecieve');
    Route::post('searchOrder', [AdminOrderController::class, 'searchOrder'])->name('searchOrder');

    // Function Delivery start here
    Route::post('searchDelivery', [AdminOrderController::class, 'searchDelivery'])->name('searchDelivery');

    // Setting Function Start Here
    Route::post('storeUnit', [SettingController::class, 'storeUnit'])->name('storeUnit');
    Route::post('updateUnit', [SettingController::class, 'updateUnit'])->name('updateUnit');
    Route::post('deleteUnit', [SettingController::class, 'deleteUnit'])->name('deleteUnit');

    // Scheduler Function Start here
    Route::post('storeCalendar', [CalendarController::class, 'storeCalendar'])->name('storeCalendar');
    Route::post('deleteCalendar', [CalendarController::class, 'deleteCalendar'])->name('deleteCalendar');
});

Route::prefix('customer')->middleware(['auth',])->group(function () {
    // Web links start here
    Route::get('cart', [CartController::class, 'index'])->name('cart');

    // Cart Function Start here
    Route::post('deleteCart', [CartController::class, 'deleteCart'])->name('deleteCart');

    // Cart Function Start Here
    Route::post('storeCart', [CartController::class, 'storeCart'])->name('storeCart');
    Route::post('updateUnit', [CartController::class, 'updateUnit'])->name('updateUnit');
    Route::post('deleteUnit', [CartController::class, 'deleteUnit'])->name('deleteUnit');

    // Order Function Start Here
    Route::get('order', [OrderController::class, 'index'])->name('order');
    Route::post('storeOrder', [OrderController::class, 'storeOrder'])->name('storeOrder');
    Route::post('deleteOrder', [OrderController::class, 'deleteOrder'])->name('deleteOrder');

    // Search Prodcut start Here
    Route::post('searchProduct', [CustomerDashboardController::class, 'searchProduct'])->name('searchProduct');
    
    // Payment function start here
});
Route::post('pay', [PaymentController::class, 'pay'])->name('pay');
Route::get('success', [PaymentController::class, 'success'])->name('success');
Route::get('cancel', [PaymentController::class, 'cancel'])->name('cancel');
require __DIR__ . '/auth.php';
