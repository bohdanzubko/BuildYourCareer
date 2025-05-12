<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\ServiceController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\JobController;
use App\Http\Controllers\JobOfferController;
use App\Http\Controllers\JobRequestController;
use App\Http\Controllers\SettingController;
use App\Http\Controllers\FeedbackController;
use App\Http\Controllers\SkillController;
use App\Http\Controllers\JobConfirmationController;
use App\Http\Controllers\ServiceRequestController;
use App\Http\Controllers\ServiceTagController;
use App\Http\Controllers\UserProfileController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    // Профіль користувача
    Route::get('/profile', [ProfileController::class, 'index'])->name('profile.index');
    Route::get('/profile/edit', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    // Додаткові сторінки профілю
    Route::get('/profile/reviews', [ProfileController::class, 'reviews'])->name('profile.reviews');
    Route::get('/profile/suggestions', [ProfileController::class, 'suggestions'])->name('profile.suggestions');

    // Панель адміністратора
    Route::get('/admin', function () {
        return view('admin.dashboard');
    })->name('admin.dashboard');

    Route::prefix('admin')->group(function () {
        Route::resource('users', UserController::class);
        Route::resource('services', ServiceController::class);
        Route::resource('categories', CategoryController::class);
        Route::resource('jobs', JobController::class);
        Route::resource('job_offers', JobOfferController::class);
        Route::resource('job_requests', JobRequestController::class);
        Route::resource('settings', SettingController::class);
        Route::resource('feedback', FeedbackController::class);
        Route::resource('skills', SkillController::class);
        Route::resource('job-confirmations', JobConfirmationController::class);
        Route::resource('service-requests', ServiceRequestController::class);
        Route::resource('service-tags', ServiceTagController::class);
        Route::resource('user-profiles', UserProfileController::class);
    });
});

require __DIR__.'/auth.php';
