<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\Auth\ForgotPasswordController;
use App\Http\Controllers\Auth\ResetPasswordController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\SubscriptionController;

use App\Http\Controllers\PaymentHistoryController;
use App\Http\Controllers\TelegramController;
use App\Http\Controllers\FinancialAssistantController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\SocialController;
use App\Http\Controllers\SharedSubscriptionController;
use App\Http\Controllers\MoneyLeakController;
use App\Http\Controllers\SubscriptionComparisonController;
use App\Http\Controllers\Admin\AdminDashboardController;


Route::get('/', function () {
    return auth()->check() ? redirect('/dashboard') : view('welcome');
});


Route::middleware('guest')->group(function () {
    Route::get('/login', [LoginController::class, 'showLoginForm'])->name('login');
    Route::post('/login', [LoginController::class, 'login']);
    Route::get('/register', [RegisterController::class, 'showRegistrationForm'])->name('register');
    Route::post('/register', [RegisterController::class, 'register']);
    Route::get('/forgot-password', [ForgotPasswordController::class, 'showLinkRequestForm'])->name('password.request');
    Route::post('/forgot-password', [ForgotPasswordController::class, 'sendResetLinkEmail'])->name('password.email');
    Route::get('/reset-password/{token}', [ResetPasswordController::class, 'showResetForm'])->name('password.reset');
    Route::post('/reset-password', [ResetPasswordController::class, 'reset'])->name('password.update');
});


Route::middleware('auth')->group(function () {
    Route::post('/logout', [LoginController::class, 'logout'])->name('logout');

    
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    
    Route::get('/subscriptions/export', [SubscriptionController::class, 'export'])->name('subscriptions.export');
    Route::post('/subscriptions/{subscription}/mark-paid', [SubscriptionController::class, 'markPaid'])->name('subscriptions.mark-paid');
    Route::post('/subscriptions/{subscription}/toggle-status', [SubscriptionController::class, 'toggleStatus'])->name('subscriptions.toggle-status');
    Route::resource('subscriptions', SubscriptionController::class);

    
    Route::get('/social', [SocialController::class, 'index'])->name('social.index');
    Route::post('/social/add', [SocialController::class, 'addFriend'])->name('social.add');
    Route::get('/social/add/{tag}', [SocialController::class, 'addFriendByTag'])->name('social.add-by-tag');
    Route::post('/social/accept/{id}', [SocialController::class, 'acceptFriend'])->name('social.accept');
    Route::delete('/social/remove/{id}', [SocialController::class, 'removeFriend'])->name('social.remove');

    
    Route::get('/shares', [SharedSubscriptionController::class, 'index'])->name('shares.index');
    Route::post('/shares', [SharedSubscriptionController::class, 'store'])->name('shares.store');
    Route::get('/shares/join/{code}', [SharedSubscriptionController::class, 'joinGroup'])->name('shares.join');
    Route::post('/shares/join/{code}', [SharedSubscriptionController::class, 'confirmJoinGroup'])->name('shares.confirm-join');
    Route::post('/shares/{id}/upload-proof', [SharedSubscriptionController::class, 'uploadProof'])->name('shares.upload-proof');
    Route::post('/shares/{id}/reject-proof', [SharedSubscriptionController::class, 'rejectProof'])->name('shares.reject-proof');
    Route::post('/shares/{id}/mark-paid', [SharedSubscriptionController::class, 'markPaid'])->name('shares.mark-paid');
    Route::post('/shares/{id}/send-reminder', [SharedSubscriptionController::class, 'sendReminder'])->name('shares.send-reminder');
    Route::post('/shares/{id}/toggle-public', [SharedSubscriptionController::class, 'togglePublic'])->name('shares.toggle-public');
    Route::delete('/shares/{id}', [SharedSubscriptionController::class, 'destroy'])->name('shares.destroy');

    
    Route::get('/discover', [\App\Http\Controllers\DiscoverController::class, 'index'])->name('discover.index');

    
    Route::get('/leaks', [MoneyLeakController::class, 'index'])->name('leaks.index');

    
    Route::get('/comparisons', [SubscriptionComparisonController::class, 'index'])->name('comparisons.index');



    
    Route::get('/payments', [PaymentHistoryController::class, 'index'])->name('payments.index');
    Route::post('/payments', [PaymentHistoryController::class, 'store'])->name('payments.store');
    Route::delete('/payments/{id}', [PaymentHistoryController::class, 'destroy'])->name('payments.destroy');

    
    Route::get('/telegram', [TelegramController::class, 'connect'])->name('telegram.connect');
    Route::post('/telegram/regenerate', [TelegramController::class, 'regenerateCode'])->name('telegram.regenerate');
    Route::post('/telegram/test-notification', [TelegramController::class, 'sendTestNotification'])->name('telegram.test-notification');
    Route::delete('/telegram', [TelegramController::class, 'disconnect'])->name('telegram.disconnect');

    
    Route::get('/assistant', [FinancialAssistantController::class, 'index'])->name('assistant');

    
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::put('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::put('/profile/password', [ProfileController::class, 'updatePassword'])->name('profile.password');

    
    Route::middleware(\App\Http\Middleware\AdminMiddleware::class)->prefix('admin')->name('admin.')->group(function () {
        Route::get('/dashboard', [AdminDashboardController::class, 'index'])->name('dashboard');
        Route::get('/users', [AdminDashboardController::class, 'users'])->name('users');
    });
});
