<?php

use App\Http\Controllers\Admin;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\Student;
use Illuminate\Support\Facades\Route;

Route::get('/', fn () => redirect()->route('login'));

Route::get('/login', [AuthController::class, 'show'])->name('login');
Route::post('/login', [AuthController::class, 'store'])->name('login.store');
Route::post('/logout', [AuthController::class, 'destroy'])->name('logout');

/* ---------------------------- Student ---------------------------- */
Route::middleware('ferms.role:student')->prefix('student')->name('student.')->group(function () {
    Route::get('/dashboard', Student\DashboardController::class)->name('dashboard');

    Route::get('/facilities', [Student\FacilityController::class, 'index'])->name('facilities.index');
    Route::get('/equipment', [Student\EquipmentController::class, 'index'])->name('equipment.index');
    Route::get('/schedule', Student\ScheduleController::class)->name('schedule');

    Route::get('/reservations', [Student\ReservationController::class, 'index'])->name('reservations.index');
    Route::post('/reserve/{type}/{id}', [Student\ReservationController::class, 'store'])
        ->whereIn('type', ['facility', 'equipment'])->whereNumber('id')->name('reservations.store');
    Route::patch('/reservations/{id}/cancel', [Student\ReservationController::class, 'cancel'])->name('reservations.cancel');

    Route::get('/inbox', [Student\InboxController::class, 'index'])->name('inbox.index');
    Route::post('/inbox/read-all', [Student\InboxController::class, 'readAll'])->name('inbox.read-all');
    Route::post('/inbox/{id}/read', [Student\InboxController::class, 'read'])->name('inbox.read');

    Route::get('/profile', [Student\ProfileController::class, 'show'])->name('profile.show');
    Route::put('/profile', [Student\ProfileController::class, 'update'])->name('profile.update');
    Route::post('/settings', [Student\ProfileController::class, 'settings'])->name('profile.settings');
});

/* ----------------------------- Admin ----------------------------- */
Route::middleware('ferms.role:admin')->prefix('admin')->name('admin.')->group(function () {
    Route::get('/dashboard', Admin\DashboardController::class)->name('dashboard');

    Route::get('/facilities', [Admin\FacilityController::class, 'index'])->name('facilities.index');
    Route::post('/facilities', [Admin\FacilityController::class, 'store'])->name('facilities.store');
    Route::put('/facilities/{id}', [Admin\FacilityController::class, 'update'])->name('facilities.update');

    Route::get('/equipment', [Admin\EquipmentController::class, 'index'])->name('equipment.index');
    Route::post('/equipment', [Admin\EquipmentController::class, 'store'])->name('equipment.store');
    Route::put('/equipment/{id}', [Admin\EquipmentController::class, 'update'])->name('equipment.update');

    Route::get('/requests', [Admin\RequestController::class, 'index'])->name('requests.index');
    Route::patch('/requests/{id}', [Admin\RequestController::class, 'decide'])->name('requests.decide');

    Route::get('/users', [Admin\UserController::class, 'index'])->name('users.index');
    Route::post('/users', [Admin\UserController::class, 'store'])->name('users.store');

    Route::get('/settings', [Admin\SettingsController::class, 'show'])->name('settings.show');
    Route::put('/settings/{tab}', [Admin\SettingsController::class, 'update'])->name('settings.update');

    Route::get('/profile', [Admin\ProfileController::class, 'show'])->name('profile.show');
    Route::put('/profile', [Admin\ProfileController::class, 'update'])->name('profile.update');
    Route::post('/profile/picture', [Admin\ProfileController::class, 'picture'])->name('profile.picture');
});
