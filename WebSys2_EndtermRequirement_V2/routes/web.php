<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\OrganizationAuthController;
use App\Http\Controllers\Auth\OsaaAuthController;
use App\Http\Controllers\Organization\OrgDashboardController;
use App\Http\Controllers\Osaa\OsaaDashboardController;
use App\Http\Controllers\Osaa\OrganizationController;
use App\Http\Controllers\Osaa\AccreditationController;
use App\Http\Controllers\Osaa\OSAAProfileController;
use App\Http\Controllers\Osaa\OsaaAnnouncementController;
use App\Http\Controllers\Organization\OrgAccreditationController as OrgAccreditationController;
use App\Http\Controllers\Organization\AnnouncementController;
use App\Http\Controllers\Organization\MembershipController;
use App\Http\Controllers\Organization\AccomplishmentController;
use App\Http\Controllers\Organization\EventController;
use App\Http\Controllers\Organization\OrgProfileController;
use App\Http\Controllers\Osaa\AccomplishmentReportController;

// Student Organization Routes
Route::prefix('org')->name('org.')->group(function () {
    Route::get('/login', [OrganizationAuthController::class, 'showLoginForm'])->name('login');
    Route::post('/login', [OrganizationAuthController::class, 'login']);
    Route::get('/register', [OrganizationAuthController::class, 'showRegistrationForm'])->name('register');
    Route::post('/register', [OrganizationAuthController::class, 'register']);
    Route::post('/logout', [OrganizationAuthController::class, 'logout'])->name('logout');

    // Ensure the user is authenticated before accessing the organization functionality
    Route::middleware(['auth:org'])->group(function () {
        Route::get('/home', [OrgDashboardController::class, 'index'])->name('home');

        Route::get('/accreditation', [OrgAccreditationController::class, 'create'])->name('accreditation.create'); // Show the form
        Route::post('/accreditation', [OrgAccreditationController::class, 'store'])->name('accreditation.store'); // Handle form submission

        // Other Organization Functionality Routes
        Route::get('/announcements', [AnnouncementController::class, 'index'])->name('announcements');
        Route::get('/membership', [MembershipController::class, 'index'])->name('membership');
        Route::get('/accomplishments', [AccomplishmentController::class, 'index'])->name('accomplishments');
        Route::get('/events', [EventController::class, 'index'])->name('events');
       
        Route::get('/profile', [OrgProfileController::class, 'edit'])->name('profile.edit');
        Route::post('/profile', [OrgProfileController::class, 'update'])->name('profile.update');
        Route::post('/profile/password', [OrgProfileController::class, 'updatePassword'])->name('profile.password');
    
        Route::get('/accomplishments', [AccomplishmentController::class, 'index'])->name('accomplishments.index');
        Route::post('/accomplishments', [AccomplishmentController::class, 'store'])->name('accomplishment.store');
    });
});

// OSAA Routes
Route::prefix('osaa')->name('osaa.')->group(function () {
    Route::get('/login', [OsaaAuthController::class, 'showLoginForm'])->name('login');
    Route::post('/login', [OsaaAuthController::class, 'login']);
    Route::get('/register', [OsaaAuthController::class, 'showRegistrationForm'])->name('register');
    Route::post('/register', [OsaaAuthController::class, 'register']);
    Route::post('/logout', [OsaaAuthController::class, 'logout'])->name('logout');

    // Ensure the user is authenticated before accessing the OSAA functionality
    Route::middleware(['auth:osaa'])->group(function () {
        Route::get('/home', [OsaaDashboardController::class, 'index'])->name('home');

        // Organization Management
        Route::resource('organization', OrganizationController::class);
        Route::patch('/organization/{organization}/status', [OrganizationController::class, 'updateStatus'])->name('organization.update.status');

        // Accreditation Management
        Route::get('/accreditation', [AccreditationController::class, 'index'])->name('accreditation.index');
        Route::get('/accreditation/{id}', [AccreditationController::class, 'show'])->name('accreditation.show');
        Route::post('/accreditation/{id}/update-status', [AccreditationController::class, 'updateStatus'])->name('accreditation.updateStatus');

        // OSAA Profile
        Route::get('/profile', [OSAAProfileController::class, 'edit'])->name('profile.edit');
        Route::post('/profile/update', [OSAAProfileController::class, 'update'])->name('profile.update');
        Route::post('/profile/password', [OSAAProfileController::class, 'changePassword'])->name('profile.password');
    
        Route::get('/announcement', [OsaaAnnouncementController::class, 'index'])->name('announcement.announcement');
        Route::post('/announcement', [OsaaAnnouncementController::class, 'store'])->name('announcement.store');
        Route::delete('/announcement/{id}', [OsaaAnnouncementController::class, 'destroy'])->name('announcement.destroy');

        // Accomplishment Reports Management
        Route::resource('accomplishment-reports', AccomplishmentReportController::class);
        Route::post('/accomplishment-reports/{id}/status', [AccomplishmentReportController::class, 'updateStatus'])->name('accomplishment-reports.updateStatus');
    });
});
