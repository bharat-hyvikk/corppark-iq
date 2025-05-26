<?php

use App\Http\Controllers\Admins\DealersController;
use App\Http\Controllers\Dealers\InvoiceManagementController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\Auth\ResetPasswordController;
use App\Http\Controllers\Auth\ForgotPasswordController;
use App\Http\Controllers\Admins\InvoiceMgmtController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\OfficeController;
use App\Http\Controllers\VehicleController;
use App\Http\Controllers\QrCodeController;
use App\Http\Middleware\DealerMiddleware;

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
    return redirect('/dashboard');
})->middleware('auth');

Route::get('/dashboard', [DashboardController::class, 'index'])
    ->name('dashboard')
    ->middleware('auth');

Route::get('/profile', function () {
    return view('account-pages.profile');
})
    ->name('profile')
    ->middleware('auth');

Route::get('/signin', function () {
    return view('account-pages.signin');
})->name('signin');

Route::get('/signup', function () {
    return view('account-pages.signup');
})
    ->name('signup')
    ->middleware('guest');

Route::get('/sign-in', [LoginController::class, 'create'])
    ->middleware('guest')
    ->name('sign-in');

Route::post('/sign-in', [LoginController::class, 'store'])->middleware('guest');

Route::post('/logout', [LoginController::class, 'destroy'])
    ->middleware('auth')
    ->name('logout');

Route::get('/forgot-password', [ForgotPasswordController::class, 'create'])
    ->middleware('guest')
    ->name('password.request');

Route::post('/forgot-password', [ForgotPasswordController::class, 'store'])
    ->middleware('guest')
    ->name('password.email');

Route::get('/reset-password/{token}', [ResetPasswordController::class, 'create'])
    ->middleware('guest')
    ->name('password.reset');
Route::post('/reset-password', [ResetPasswordController::class, 'store'])->middleware('guest');

Route::get('user-profile', [ProfileController::class, 'index'])
    ->name('users.profile')
    ->middleware('auth');
Route::post('/laravel-examples/user-profile/update', [ProfileController::class, 'update'])
    ->name('admin.update')
    ->middleware('auth');
Route::get('/laravel-examples/users-management', [UserController::class, 'index'])
    ->name('users-management')
    ->middleware('auth');
// route::get('/dealersmanage', [DealersController::class, 'index'])->name('dealers.manage')->middleware('admin');
// route::post('/save', [DealersController::class, 'store'])->name('dealers.save')->middleware('admin');

route::prefix('users')
    ->middleware('auth')
    ->group(function () {
        route::get('manage', [UserController::class, 'index'])->name('users.manage');
        route::post('save', [UserController::class, 'store'])->name('users.save');
        route::post('edit', [UserController::class, 'edit'])->name('users.edit');
        route::post('update', [UserController::class, 'update'])->name('users.update');
        route::post('delete', [UserController::class, 'destroy'])->name('users.delete');
        route::post('status', [UserController::class, 'updateStatus'])->name('users.toggleStatus');
    });

// ** office management
route::prefix('offices')
    ->middleware('auth')
    ->group(function () {
        route::get('manage', [OfficeController::class, 'index'])->name('offices.manage');
        route::post('save', [OfficeController::class, 'store'])->name('offices.save');
        route::post('edit', [OfficeController::class, 'edit'])->name('offices.edit');
        route::post('update', [OfficeController::class, 'update'])->name('offices.update');
        route::post('delete', [OfficeController::class, 'destroy'])->name('offices.delete');
    });

// ** vehicle management
route::prefix('vehicles')
    ->middleware('auth')
    ->group(function () {
        route::get('manage', [VehicleController::class, 'index'])->name('vehicles.manage');
        route::post('save', [VehicleController::class, 'store'])->name('vehicles.save');
        route::post('edit', [VehicleController::class, 'edit'])->name('vehicles.edit');
        route::post('update', [VehicleController::class, 'update'])->name('vehicles.update');
        route::post('delete', [VehicleController::class, 'destroy'])->name('vehicles.delete');
    });

// ** Qr Code Management
Route::get('/qr-code', [QrCodeController::class, 'index'])->name('qrcode.index')->middleware("auth");
Route::get('/generate-qrcode', [QrCodeController::class, 'generateQrCode'])->name('qrcode.generate')->middleware("auth");
Route::get('/download-qrcode', [QrCodeController::class, 'downloadQrCode'])->name('qrcode.download')->middleware("auth");
