<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\ComplaintController;
use App\Http\Controllers\AdminComplaintController;
use App\Http\Controllers\AdminCategoryController;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/users/login', [UserController::class, 'showLoginForm'])->name('users.login');
Route::post('/users/login', [UserController::class, 'login']);
Route::post('/users/forgot-password', [UserController::class, 'forgotPassword']);

Route::get('/users/register', [UserController::class, 'showRegistrationForm'])->name('users.register');
Route::post('/users/register', [UserController::class, 'register']);
Route::post('/users/check-availability', [UserController::class, 'checkAvailability']);

// User routes
Route::get('/users/dashboard', [UserController::class, 'dashboard'])->name('users.dashboard');
Route::get('/users/profile', [UserController::class, 'profile'])->name('users.profile');
Route::post('/users/profile', [UserController::class, 'updateProfile']);
Route::get('/users/change-password', [UserController::class, 'changePasswordForm'])->name('users.change-password');
Route::post('/users/change-password', [UserController::class, 'updatePassword']);
Route::get('/users/helplines', [UserController::class, 'helplines'])->name('users.helplines');
Route::get('/users/register-complaint', [ComplaintController::class, 'create'])->name('users.register-complaint');
Route::post('/users/register-complaint', [ComplaintController::class, 'store']);
Route::post('/users/getsubcat', [ComplaintController::class, 'getSubcategory']);
Route::get('/users/complaint-history', [ComplaintController::class, 'history'])->name('users.complaint-history');
Route::get('/users/complaint-details/{id}', [ComplaintController::class, 'show'])->name('users.complaint-details');
Route::get('/users/logout', [UserController::class, 'logout'])->name('users.logout');

Route::get('/admin/login', [AdminController::class, 'showLoginForm'])->name('admin.login');
Route::post('/admin/login', [AdminController::class, 'login']);

Route::get('/admin/dashboard', [AdminController::class, 'dashboard'])->name('admin.dashboard');
Route::get('/admin/logout', [AdminController::class, 'logout'])->name('admin.logout');

// Admin Users & Helplines
Route::get('/admin/manage-users', [AdminController::class, 'manageUsers'])->name('admin.manage-users');
Route::get('/admin/user-logs', [AdminController::class, 'userLogs'])->name('admin.user-logs');
Route::get('/admin/helplines', [AdminController::class, 'helplines'])->name('admin.helplines');
Route::post('/admin/helplines', [AdminController::class, 'storeHelpline']);
Route::get('/admin/helplines/delete/{id}', [AdminController::class, 'destroyHelpline']);

// Admin Complaints
Route::get('/admin/notprocess-complaint', [AdminComplaintController::class, 'notProcessed'])->name('admin.notprocess-complaint');
Route::get('/admin/inprocess-complaint', [AdminComplaintController::class, 'inProcess'])->name('admin.inprocess-complaint');
Route::get('/admin/closed-complaint', [AdminComplaintController::class, 'closed'])->name('admin.closed-complaint');
Route::get('/admin/complaint-details/{id}', [AdminComplaintController::class, 'show'])->name('admin.complaint-details');
Route::post('/admin/complaint-details/{id}', [AdminComplaintController::class, 'updateStatus']);

// Admin Categories & States
Route::get('/admin/category', [AdminCategoryController::class, 'categories'])->name('admin.category');
Route::post('/admin/category', [AdminCategoryController::class, 'storeCategory']);
Route::get('/admin/category/delete/{id}', [AdminCategoryController::class, 'destroyCategory']);

Route::get('/admin/subcategory', [AdminCategoryController::class, 'subcategories'])->name('admin.subcategory');
Route::get('/admin/state', [AdminCategoryController::class, 'states'])->name('admin.state');
