<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\AuthController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\OrganizerController;
use App\Http\Controllers\EventController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\CheckoutController;
use App\Http\Controllers\BookingController;
// Route::get('/', function () {
//     return view('welcome');
// });
Route::get('/', [HomeController::class, 'index'])->name('home');
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
    Route::get('/tickets/sales', [OrganizerController::class, 'showTicketSales'])->name('tickets.sales');
    Route::get('/attendees', [OrganizerController::class, 'attendees'])->name('attendees.index');
    Route::get('/payments', [OrganizerController::class, 'payments'])->name('payments.index');
    Route::get('/reports', [OrganizerController::class, 'reports'])->name('reports.index');
    Route::get('/dashboard', [OrganizerController::class, 'dashboard'])->name('organizer.dashboard');
    Route::get('/events/manage', [OrganizerController::class, 'manageEvents'])->name('organizer.events');
});

// Attendee Routes
Route::middleware(['role:attendee'])->group(function () {
    Route::get('/events/{id}/book', [HomeController::class, 'bookNow'])->name('events.book');
    Route::post('/cart/add', [CartController::class, 'addToCart'])->name('cart.add');
    Route::get('/cart', [CartController::class, 'viewCart'])->name('cart.view');
    Route::post('/cart/update', [CartController::class, 'updateCart'])->name('cart.update');
    Route::post('/checkout', [CheckoutController::class, 'processCheckout'])->name('checkout.process');
    Route::get('/booking/details', [BookingController::class, 'bookingDetails'])->name('booking.details');
});

// Route for redirecting to login if the user is not logged in
Route::get('/login/attendee', function () {
    return redirect()->route('login', ['role' => 'attendee']);
})->name('login.attendee');