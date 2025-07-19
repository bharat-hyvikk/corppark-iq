<?php

use App\Http\Controllers\Admins\DealersController;
use App\Http\Controllers\BuildingController;
use App\Http\Controllers\Dealers\InvoiceManagementController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\Auth\ResetPasswordController;
use App\Http\Controllers\Auth\ForgotPasswordController;
use App\Http\Controllers\Admins\InvoiceMgmtController;
use App\Http\Controllers\ContactUsController;
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
})->middleware(['auth','admin']);

Route::get('/dashboard', [DashboardController::class, 'index'])
    ->name('dashboard')
    ->middleware(['auth','admin']);

Route::get('/profile', function () {
    return view('account-pages.profile');
})
    ->name('profile')
    ->middleware(['auth','admin']);

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
    ->middleware(['auth','admin'])
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
    ->middleware(['auth','admin']);
Route::post('/laravel-examples/user-profile/update', [ProfileController::class, 'update'])
    ->name('admin.update')
    ->middleware(['auth','admin']);
Route::get('/laravel-examples/users-management', [UserController::class, 'index'])
    ->name('users-management')
    ->middleware(['auth','admin']);
// route::get('/dealersmanage', [DealersController::class, 'index'])->name('dealers.manage')->middleware('admin');
// route::post('/save', [DealersController::class, 'store'])->name('dealers.save')->middleware('admin');

route::prefix('users')
    ->middleware(['auth','admin'])
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
    ->middleware(['auth','admin'])
    ->group(function () {
        route::get('manage', [OfficeController::class, 'index'])->name('offices.manage');
        route::post('save', [OfficeController::class, 'store'])->name('offices.save');
        route::post('edit', [OfficeController::class, 'edit'])->name('offices.edit');
        route::post('update', [OfficeController::class, 'update'])->name('offices.update');
        route::post('delete', [OfficeController::class, 'destroy'])->name('offices.delete');
    });

// ** vehicle management
route::prefix('vehicles')
    ->middleware(['auth','admin'])
    ->group(function () {
        route::get('manage', [VehicleController::class, 'index'])->name('vehicles.manage');
        route::post('save', [VehicleController::class, 'store'])->name('vehicles.save');
        route::post('edit', [VehicleController::class, 'edit'])->name('vehicles.edit');
        route::post('update', [VehicleController::class, 'update'])->name('vehicles.update');
        route::post('delete', [VehicleController::class, 'destroy'])->name('vehicles.delete');
    });

route::prefix('buildings')
    ->middleware(['auth','admin'])
    ->group(function () {
        route::get('manage', [BuildingController::class, 'index'])->name('buildings.manage');
        route::post('save', [BuildingController::class, 'store'])->name('buildings.save');
        route::post('edit', [BuildingController::class, 'edit'])->name('buildings.edit');
        route::post('update', [BuildingController::class, 'update'])->name('buildings.update');
        route::post('delete', [BuildingController::class, 'destroy'])->name('buildings.delete');
    });

// ** Qr Code Management
Route::get('/qr-code', [QrCodeController::class, 'index'])->name('qrcode.index')->middleware("auth");
Route::get('/generate-qrcode', [QrCodeController::class, 'generateQrCode'])->name('qrcode.generate')->middleware("auth");
Route::get('/download-qrcode/{qrId?}', [QrCodeController::class, 'downloadQrCode'])->name('qrcode.download')->middleware("auth");

// privacy policy
Route::get('/privacy-policy', function () {
    return view('privacy');
})->name('privacy-policy');

// contact us
Route::get('/contact-us', function () {
    return view('contact');
})->name('contact-us');

// send email using contact us controller
Route::get('/send-email', [ContactUsController::class, 'sendEmail'])->name('send-email');
