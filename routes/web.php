<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\AuthController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\OrganizerController;
use App\Http\Controllers\EventController;
// Route::get('/', function () {
//     return view('welcome');
// });
Route::get('/', [AuthController::class, 'showLogin'])->name('login');
Route::get('/register', [AuthController::class, 'showRegister'])->name('register');
Route::post('/register', [AuthController::class, 'register']);
Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
Route::post('/login', [AuthController::class, 'login'])->name('login');
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

Route::get('/admin/dashboard', [DashboardController::class, 'index'])->name('administrator.dashboard.admin');
Route::get('/attendee/dashboard', [DashboardController::class, 'index'])->name('administrator.dashboard.attendee');
Route::get('/organizer/dashboard', [DashboardController::class, 'index'])->name('administrator.dashboard.organizer');



Route::middleware(['role:organizer'])->group(function () {
    Route::resource('events', EventController::class);
    Route::get('/events/{id}/view', [EventController::class, 'view'])->name('events.view');
    Route::get('/tickets/sales', [OrganizerController::class, 'ticketSales'])->name('tickets.sales');
    Route::get('/attendees', [OrganizerController::class, 'attendees'])->name('attendees.index');
    Route::get('/payments', [OrganizerController::class, 'payments'])->name('payments.index');
    Route::get('/reports', [OrganizerController::class, 'reports'])->name('reports.index');
    Route::get('/dashboard', [OrganizerController::class, 'dashboard'])->name('organizer.dashboard');
    Route::get('/events/manage', [OrganizerController::class, 'manageEvents'])->name('organizer.events');
});