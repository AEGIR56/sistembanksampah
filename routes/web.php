<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\Auth\ForgotPasswordController;
use App\Http\Controllers\Admin\AdminDashboardController;
use App\Http\Controllers\Admin\AccountManagementController;
use App\Http\Controllers\Admin\AdminApprovalController;
use App\Http\Controllers\Admin\ShopItemController;
use App\Http\Controllers\Admin\CalendarManagementController;
use App\Http\Controllers\Admin\AdminPasswordResetController;
use App\Http\Controllers\staff\StaffDashboardController;
use App\Http\Controllers\staff\StaffPickupController;
use App\Http\Controllers\staff\StaffPickupReportController;
use App\Http\Controllers\user\PickupController;
use App\Http\Controllers\user\UserDashboardController;
use App\Http\Controllers\User\PointExchangeController;
use App\Http\Controllers\User\CartController;
use App\Http\Controllers\User\ProfileController;


/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});
Route::get('/terms', function () {
    return view('terms');
});

Route::get('/policy', function () {
    return view('policy');
});
// Login Routes
Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');
Route::post('/login', [AuthController::class, 'login']);
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

//Register Routes
Route::get('/register', [AuthController::class, 'showRegisterForm'])->name('register.form');
Route::post('/register', [AuthController::class, 'register'])->name('register');
Route::get('/login', function () {
    return view('auth.login'); // Make sure you create login view
})->name('login');

//Password Recovery Routes
Route::get('/forgot-password', [ForgotPasswordController::class, 'showForgotForm'])->name('password.request');
Route::post('/forgot-password', [ForgotPasswordController::class, 'requestReset'])->name('password.email');


// Admin Dashboard Routes
Route::get('/admin/dashboard', [AdminDashboardController::class, 'index'])
    ->name('admin.dashboard')
    ->middleware('auth');
Route::middleware(['auth', 'nocache', 'role:admin'])->group(function () {
    // Admin account management
    Route::get('/admin/accounts', [AccountManagementController::class, 'index'])->name('admin.accounts.index');
    Route::get('/admin/accounts/create', [AccountManagementController::class, 'create'])->name('admin.accounts.create');
    Route::post('/admin/accounts', [AccountManagementController::class, 'store'])->name('admin.accounts.store');
    Route::get('/admin/accounts/{user}/edit', [AccountManagementController::class, 'edit'])->name('admin.accounts.edit');
    Route::put('/admin/accounts/{user}', [AccountManagementController::class, 'update'])->name('admin.accounts.update');
    Route::delete('/admin/accounts/{user}', [AccountManagementController::class, 'destroy'])->name('admin.accounts.destroy');
    Route::get('/admin/accounts/data', [AccountManagementController::class, 'data'])->name('admin.accounts.data');


    //PasswordReset
    Route::get('/admin/password-requests', [AdminPasswordResetController::class, 'index'])->name('admin.password.requests');
    Route::post('/admin/password-requests/{id}/reset', [AdminPasswordResetController::class, 'reset'])->name('admin.password.reset');

    // Data logs
    Route::get('/admin/dataLogs', [AdminDashboardController::class, 'dataLogs'])->name('admin.dataLogs');

    // Schedule
    Route::get('/admin/schedule', [AdminDashboardController::class, 'scheduleManagement'])->name('admin.scheduleManagement');
    Route::get('/admin/schedule-management', [CalendarManagementController::class, 'index'])->name('admin.scheduleManagement');
    Route::get('/schedule-management', [CalendarManagementController::class, 'index'])->name('admin.schedule');
    Route::post('/calendar/update', [CalendarManagementController::class, 'update'])->name('admin.calendar.update');
    Route::post('/admin/calendar/delete', [CalendarManagementController::class, 'destroy'])->name('admin.calendar.delete');

    // Approval
    Route::get('/admin/approvals', [AdminApprovalController::class, 'index'])->name('admin.approvals.index');
    Route::post('pickups/{id}/approve', [AdminApprovalController::class, 'approve'])->name('admin.pickup.approve');
    Route::post('pickups/{id}/reject', [AdminApprovalController::class, 'reject'])->name('admin.pickup.reject');
    Route::get('/approval/pickups', [AdminApprovalController::class, 'index'])->name('admin.approval.index');
    Route::post('/approval/pickups/{id}/approve', [AdminApprovalController::class, 'approve'])->name('admin.approval.approve');
    Route::post('/approval/pickups/{id}/reject', [AdminApprovalController::class, 'reject'])->name('admin.approval.reject');

    // Point shop
    Route::get('/pointShopManagement', [ShopItemController::class, 'index'])->name('admin.pointShopManagement');
    Route::post('/pointShopManagement', [ShopItemController::class, 'store'])->name('admin.pointShopManagement.store');
    Route::delete('/pointShopManagement/{id}', [ShopItemController::class, 'destroy'])->name('admin.pointShopManagement.destroy');
});

//Staff Dashboard Routes
Route::middleware(['auth', 'nocache', 'role:staff'])->prefix('staff')->group(function () {
    // Dashboard staff
    Route::get('/dashboard', [StaffDashboardController::class, 'index'])->name('staff.dashboard');
    Route::get('/dashboard/data', [StaffDashboardController::class, 'getData'])->name('staff.dashboard.data');

    // Pickup utama (halaman list)
    Route::get('/pickups', [StaffPickupController::class, 'index'])->name('staff.pickups.index');

    // Detail pickup (show by id)
    Route::get('/pickups/{id}', [StaffPickupController::class, 'show'])->name('staff.pickups.show');

    // Update status pickup
    Route::post('/pickups/{id}/update-status', [StaffPickupController::class, 'updateStatus'])
        ->name('staff.pickups.updateStatus');

    // API untuk ambil data pickup (untuk modal laporan)
    Route::get('/api/pickups/{id}', [StaffPickupController::class, 'apiPickupDetail'])->name('staff.pickups.api');

    // Simpan laporan pickup (melalui modal)
    Route::post('/pickups/{id}/report', [StaffPickupReportController::class, 'store'])->name('staff.pickups.report');
});



//User Dashboard Routes
Route::middleware(['auth', 'nocache', 'role:user'])->prefix('user')->group(function () {
    // 📊 Dashboard
    Route::get('/dashboard', [UserDashboardController::class, 'index'])->name('user.dashboard');
    Route::get('/waste-types/data', [UserDashboardController::class, 'getData'])->name('user.waste-types.data');
    // 🗓️ Schedule & Pickup
    Route::get('/schedule', [PickupController::class, 'index'])->name('user.schedule');
    Route::post('/user/schedule/submit', [PickupController::class, 'store'])->name('pickup.submit');
    // 💳 Transaksi
    Route::get('/transaction', [UserDashboardController::class, 'transaction'])->name('user.transaction');
    // routes/web.php
    Route::get('/transactions/pickup', [UserDashboardController::class, 'pickupData'])->name('user.transactions.pickup');
    Route::get('/transactions/redeem', [UserDashboardController::class, 'redeemData'])->name('user.transactions.redeem');

    // 🪙 Poin Exchange
    Route::get('/pointexchange', [PointExchangeController::class, 'index'])->name('user.pointExchange');
    Route::post('/pointexchange', [PointExchangeController::class, 'exchange'])->name('user.pointExchange.exchange');
    // 🛒 Cart
    Route::prefix('cart')->group(function () {
        Route::get('/', [CartController::class, 'index'])->name('user.cart');
        Route::post('/add', [CartController::class, 'add'])->name('user.cart.add');
        Route::post('/update', [CartController::class, 'update'])->name('user.cart.update');
        Route::post('/delete', [CartController::class, 'delete'])->name('user.cart.delete');
        Route::post('/checkout', [CartController::class, 'checkout'])->name('user.cart.checkout');
        Route::get('/count', [CartController::class, 'count']);
    });
    //profile
    Route::get('/profile', [ProfileController::class, 'show'])->name('profile');
});







