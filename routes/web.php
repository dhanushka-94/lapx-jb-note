<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\CustomerController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\JobController;
use App\Http\Controllers\SmsLogController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\ReportController;
use App\Http\Controllers\TechnicianController;

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

// Redirect root to login page
Route::get('/', function () {
    return redirect()->route('login');
});

// Authentication Routes
Route::get('/login', [LoginController::class, 'showLoginForm'])->name('login');
Route::post('/login', [LoginController::class, 'login']);
Route::post('/logout', [LoginController::class, 'logout'])->name('logout');

// Dashboard and Protected Routes
Route::middleware('auth')->group(function () {
    // Dashboard
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    
    // User Management
    Route::resource('users', UserController::class);
    
    // Technician Management
    Route::resource('technicians', TechnicianController::class);
    Route::get('/technicians/{technician}/jobs', [TechnicianController::class, 'jobs'])->name('technicians.jobs');
    
    // Customer Management
    Route::resource('customers', CustomerController::class);
    
    // Job Management
    Route::resource('jobs', JobController::class);

    // Job status update route - accept both PATCH and POST for better compatibility
    Route::match(['patch', 'post'], '/jobs/{job}/status', [JobController::class, 'updateStatus'])->name('jobs.update-status');
    
    // Job highlights route
    Route::get('/job-highlights', [JobController::class, 'highlights'])->name('jobs.highlights');
    
    // SMS Logs
    Route::get('/sms-logs', [SmsLogController::class, 'index'])->name('sms-logs.index');
    Route::get('/sms-logs/{smsLog}', [SmsLogController::class, 'show'])->name('sms-logs.show');

    // Receipt route
    Route::get('/jobs/{job}/receipt', [JobController::class, 'generateReceipt'])->name('jobs.receipt');

    // Reports
    Route::get('/reports', [ReportController::class, 'index'])->name('reports.index');
    Route::get('/reports/export', [ReportController::class, 'export'])->name('reports.export');
});
