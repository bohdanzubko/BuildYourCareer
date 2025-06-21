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
    return view('home');
})->name('home');

// Публічні сторінки послуг, вакансій, категорій
Route::get('/services', [ServiceController::class, 'publicIndex'])->name('services.public.index');
Route::get('/services/{service}', [ServiceController::class, 'show'])->name('services.public.show');
Route::get('/jobs', [JobController::class, 'publicIndex'])->name('jobs.public.index');
Route::get('/jobs/{job}', [JobController::class, 'show'])->name('jobs.public.show');
Route::get('/categories', [CategoryController::class, 'publicIndex'])->name('categories.public.index');
Route::get('/categories/{category}', [CategoryController::class, 'show'])->name('categories.public.show');

// Група маршрутів для авторизованих користувачів (особистий профіль)
Route::middleware('auth')->group(function () {
    // Профіль — всі ролі
    Route::get('/profile', [ProfileController::class, 'index'])->name('profile.index');
    Route::get('/profile/edit', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::post('/profile/edit', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
    Route::get('/profile/my-reviews', [ProfileController::class, 'myReviews'])->name('profile.my_reviews');
    Route::get('/profile/reviews-about-me', [ProfileController::class, 'reviewsAboutMe'])->name('profile.reviews_about_me');
    Route::get('/profile/suggestions', [ProfileController::class, 'suggestions'])->name('profile.suggestions');

    // Профіль — worker, admin
    Route::get('/profile/services', [ProfileController::class, 'services'])->name('profile.services');
    Route::get('/profile/services/create', [ServiceController::class, 'createPublic'])->name('profile.services.create');
    Route::post('/profile/services', [ServiceController::class, 'storePublic'])->name('profile.services.store');
    Route::get('/profile/services/{service}/edit', [ServiceController::class, 'editPublic'])->name('profile.services.edit');
    Route::put('/profile/services/{service}', [ServiceController::class, 'updatePublic'])->name('profile.services.update');
    Route::delete('/profile/services/{service}', [ServiceController::class, 'destroyPublic'])->name('profile.services.destroy');
    // Заявки/пропозиції робітника
    Route::get('/profile/service-requests', [ProfileController::class, 'requestsForMyServices'])->name('profile.service_requests');
    Route::post('/profile/service-requests/{request}/confirm', [ProfileController::class, 'confirmServiceRequest'])->name('service_requests.confirm');
    Route::get('/profile/job-requests', [ProfileController::class, 'myJobRequests'])->name('profile.job_requests');
    Route::get('/profile/job-offers', [ProfileController::class, 'jobOffersForMe'])->name('profile.job_offers');
    Route::post('/profile/job-offers/{offer}/confirm', [ProfileController::class, 'confirmJobOffer'])->name('job_offers.confirm');

    // Профіль — employer, admin
    Route::get('/profile/jobs', [ProfileController::class, 'jobs'])->name('profile.jobs');
    Route::get('/profile/jobs/create', [JobController::class, 'createPublic'])->name('profile.jobs.create');
    Route::post('/profile/jobs', [JobController::class, 'storePublic'])->name('profile.jobs.store');
    Route::get('/profile/jobs/{job}/edit', [JobController::class, 'editPublic'])->name('profile.jobs.edit');
    Route::put('/profile/jobs/{job}', [JobController::class, 'updatePublic'])->name('profile.jobs.update');
    Route::delete('/profile/jobs/{job}', [JobController::class, 'destroyPublic'])->name('profile.jobs.destroy');
    // Заявки/пропозиції роботодавця
    Route::get('/profile/job-requests-for-my-jobs', [ProfileController::class, 'jobRequestsForMyJobs'])->name('profile.job_requests_for_my_jobs');
    Route::post('/profile/job-requests/{request}/confirm', [ProfileController::class, 'confirmJobRequest'])->name('job_requests.confirm');
    Route::get('/profile/my-job-offers', [ProfileController::class, 'myJobOffers'])->name('profile.my_job_offers');

    // Публічна сторінка профілю користувача — доступна всім авторизованим
    Route::get('/profile/{user}', [ProfileController::class, 'index'])->name('profile.public');

    // Панель адміністратора — тільки admin
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
