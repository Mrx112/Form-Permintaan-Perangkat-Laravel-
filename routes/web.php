<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PermintaanController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\DashboardController;

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

// Landing page
Route::get('/', function () {
	return view('index');
})->name('home');

// Dev-only quick login for admin (only when APP_DEBUG=true)
if (config('app.debug')) {
	Route::get('dev-login/admin', function(){
		$user = \App\Models\User::where('role','admin')->first();
		if (!$user) abort(404, 'No admin user found');
		auth()->login($user);
		return redirect()->route('permintaan.index');
	})->name('dev.login.admin');
}

// Dashboard (internal)
Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

Route::resource('permintaan', PermintaanController::class);
Route::post('permintaan-autosave', [PermintaanController::class, 'autosave'])->name('permintaan.autosave');
Route::get('permintaan-history', [PermintaanController::class, 'history'])->name('permintaan.history');
Route::delete('permintaan/{permintaan}/attachment/{filename}', [PermintaanController::class, 'deleteAttachment'])->name('permintaan.attachment.delete');

// Profile routes
Route::middleware('auth')->group(function(){
	Route::get('profile', [\App\Http\Controllers\ProfileController::class, 'edit'])->name('profile.edit');
	Route::post('profile', [\App\Http\Controllers\ProfileController::class, 'update'])->name('profile.update');
});

// Auth routes
Route::get('login', [AuthController::class, 'showLogin'])->name('login');
Route::post('login', [AuthController::class, 'login'])->name('login.post');
Route::get('register', [AuthController::class, 'showRegister'])->name('register');
Route::post('register', [AuthController::class, 'register'])->name('register.post');
Route::post('logout', [AuthController::class, 'logout'])->name('logout');

// Admin routes (consolidated)
Route::middleware(['auth','admin'])->prefix('admin')->name('admin.')->group(function () {
	Route::get('users', [\App\Http\Controllers\UserController::class, 'index'])->name('users.index');
	Route::get('users/create', [\App\Http\Controllers\UserController::class, 'create'])->name('users.create');
	Route::post('users', [\App\Http\Controllers\UserController::class, 'store'])->name('users.store');
	Route::delete('users/{user}', [\App\Http\Controllers\UserController::class, 'destroy'])->name('users.destroy');
	Route::get('users/{user}', [\App\Http\Controllers\UserController::class, 'show'])->name('users.show');
	Route::post('users/{user}/send-activation', [\App\Http\Controllers\UserController::class, 'sendActivation'])->name('users.sendActivation');
	Route::post('users/{user}/approve', [\App\Http\Controllers\UserController::class, 'approve'])->name('users.approve');

	// Admin other pages
	Route::get('settings', [\App\Http\Controllers\AdminSettingsController::class, 'edit'])->name('settings');
	Route::post('settings', [\App\Http\Controllers\AdminSettingsController::class, 'update'])->name('settings.update');

	// Avatar deletion for profile
	Route::post('profile/avatar/delete', [\App\Http\Controllers\ProfileController::class, 'destroyAvatar'])->name('profile.avatar.delete');
	Route::get('reports', [\App\Http\Controllers\AdminReportsController::class, 'index'])->name('reports');

	// Admin exports and preview for permintaan
	Route::get('permintaan/preview', [\App\Http\Controllers\PermintaanController::class, 'preview'])->name('permintaan.preview');
	Route::post('permintaan/export', [\App\Http\Controllers\PermintaanController::class, 'export'])->name('permintaan.export');
});

// Public activation route
Route::get('activate/{token}', [\App\Http\Controllers\UserController::class, 'activate'])->name('auth.activate');

// (export/preview routes are registered in the consolidated admin group above)
