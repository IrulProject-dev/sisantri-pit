<?php

use App\Http\Controllers\Admin\AdminController;
use App\Http\Controllers\Assesments\AssessmentCategoryController;
use App\Http\Controllers\Assesments\AssessmentComponentController;
use App\Http\Controllers\Assesments\AssessmentController;
use App\Http\Controllers\Assesments\AssessmentDetailController;
use App\Http\Controllers\Assesments\AssessmentPeriodController;
use App\Http\Controllers\Assesments\AssessmentTargetController;
use App\Http\Controllers\Assesments\AssessmentTemplateController;
use App\Http\Controllers\AttendanceController;
use App\Http\Controllers\AttendanceSessionController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\BatchController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\DivisionController;
use App\Http\Controllers\ImporSantriController;
use App\Http\Controllers\Mentor\CreateMentorController;
use App\Http\Controllers\Mentor\RoleMentorController;
use App\Http\Controllers\ReportController;
use App\Http\Controllers\Santri\RoleSantriController;
use App\Http\Controllers\SantriController;
use App\Http\Controllers\Superadmin\SuperAdminController;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Route;








Route::get('/', function () {
    return redirect()->route('dashboard');
});

// Authentication routes
Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');
Route::post('/login', [AuthController::class, 'login']);
Route::get('/register', [AuthController::class, 'showRegistrationForm'])->name('register');
Route::post('/register', [AuthController::class, 'register']);
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

// Protected routes
Route::middleware(['auth'])->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    // Admin only routes
    Route::middleware(['can:admin'])->group(function () {
        Route::resource('batches', BatchController::class);
        Route::resource('divisions', DivisionController::class);
        Route::resource('santris', SantriController::class);
        Route::resource('attendance-sessions', AttendanceSessionController::class);
        Route::get('/attendances/export', [AttendanceController::class, 'export'])->name('attendances.export');
        Route::resource('attendances', AttendanceController::class);
        Route::resource('mentors', CreateMentorController::class);
        Route::resource('superadmins', SuperAdminController::class);
        Route::resource('admins', AdminController::class);

        Route::resource('assessment-components', AssessmentComponentController::class);
        Route::resource('assessment-templates', AssessmentTemplateController::class);
        Route::resource('assessment-targets', AssessmentTargetController::class);
        Route::resource('assessment-categories', AssessmentCategoryController::class);
        Route::resource('assessment-details', AssessmentDetailController::class);
        Route::resource('assessment-periods', AssessmentPeriodController::class);
        Route::resource('assessments', AssessmentController::class);
        Route::resource('report', ReportController::class);
        Route::get('report/{assessment}/pdf', [ReportController::class, 'downloadPdf'])->name('report.downloadPdf');
        Route::post('report/{assessment}/send-email', [ReportController::class, 'sendEmail'])->name('report.sendEmail');

    Route::get('/impor-santri', [ImporSantriController::class, 'index'])
        ->name('impor-santri.index');

    Route::post('/impor-santri/lokal', [ImporSantriController::class, 'imporLokal'])
        ->name('impor-santri.lokal');
    });

    // Mentor only
    Route::middleware(['can:mentor'])->group(function () {
        Route::get('/role-mentor', [RoleMentorController::class, 'mentor']);
    });

    // Santri only
    Route::middleware(['can:santri'])->group(function () {
        Route::get('/role-santri', [RoleSantriController::class, 'santri']);
    });
});
