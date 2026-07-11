<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\Organizer\EventController as OrganizerEventController;
use App\Http\Controllers\Organizer\ProfileController as OrganizerProfileController;
use App\Http\Controllers\Organizer\ReportController as OrganizerReportController;
use App\Http\Controllers\Visitor\EventController as VisitorEventController;
use App\Http\Controllers\Visitor\ProfileController as VisitorProfileController;
use App\Http\Controllers\Visitor\CartController;
use App\Http\Controllers\Visitor\CheckoutController;
use App\Http\Controllers\Visitor\TicketController;
use App\Http\Controllers\Visitor\OrganizerController;

// Home
Route::get('/', function () {
    return view('welcome');
})->name('home');

// Auth (guest)
Route::middleware('guest')->group(function () {
    Route::get('/login', [LoginController::class, 'showLoginForm'])->name('login');
    Route::post('/login', [LoginController::class, 'login']);
    Route::get('/register', [RegisterController::class, 'showRegistrationForm'])->name('register');
    Route::post('/register', [RegisterController::class, 'register']);
});

Route::post('/logout', [LoginController::class, 'logout'])->name('logout');

// Organizer Routes
Route::prefix('organizer')->name('organizer.')->middleware(['organizer', 'check.banned'])->group(function () {
    Route::get('/events', [OrganizerEventController::class, 'index'])->name('events.index');
    Route::get('/events/create', [OrganizerEventController::class, 'create'])->name('events.create');
    Route::post('/events', [OrganizerEventController::class, 'store'])->name('events.store');
    Route::get('/events/{event}', [OrganizerEventController::class, 'show'])->name('events.show');
    Route::post('/events/{event}/pay-fee', [OrganizerEventController::class, 'payFee'])->name('events.pay-fee');
    Route::get('/profile', [OrganizerProfileController::class, 'edit'])->name('profile.edit');
    Route::put('/profile', [OrganizerProfileController::class, 'update'])->name('profile.update');
    Route::get('/report', [OrganizerReportController::class, 'index'])->name('report.index');
});

// Visitor Routes
Route::prefix('visitor')->name('visitor.')->group(function () {
    
    // Visitor event browsing
    Route::get('/events', [VisitorEventController::class, 'index'])->name('events.index');
    Route::get('/events/{event}', [VisitorEventController::class, 'show'])->name('events.show');

    Route::middleware(['visitor', 'check.banned'])->group(function () {
        // Visitor profile routes
        Route::get('/profile', [VisitorProfileController::class, 'edit'])->name('profile.edit');
        Route::put('/profile', [VisitorProfileController::class, 'update'])->name('profile.update');

        // Visitor cart
        Route::post('/cart/add/{event}', [CartController::class, 'add'])->name('cart.add');
        Route::get('/cart', [CartController::class, 'show'])->name('cart.show');
        Route::delete('/cart/remove', [CartController::class, 'remove'])->name('cart.remove');

        // Visitor checkout
        Route::get('/checkout/visitor-form', [CheckoutController::class, 'showVisitorForm'])->name('checkout.visitor_form');
        Route::post('/checkout/visitor-data', [CheckoutController::class, 'storeVisitorData'])->name('checkout.visitor_data');
        Route::get('/checkout/review', [CheckoutController::class, 'review'])->name('checkout.review');
        Route::post('/checkout/process', [CheckoutController::class, 'process'])->name('checkout.process');

        // Visitor payment
        Route::get('/payment/{order}', [CheckoutController::class, 'paymentPage'])->name('payment.page');
        Route::post('/payment/{order}/select', [CheckoutController::class, 'selectPayment'])->name('payment.select');
        Route::post('/payment/{order}/simulate', [CheckoutController::class, 'simulatePayment'])->name('payment.simulate');

        // Visitor tickets
        Route::get('/tickets', [TicketController::class, 'index'])->name('tickets.index');
        Route::get('/ticket/{order}', [TicketController::class, 'show'])->name('ticket.show');
        Route::get('/ticket/{order}/qr/{itemId}', [TicketController::class, 'qr'])->name('ticket.qr');
        Route::get('/ticket/{order}/continue-payment', [TicketController::class, 'continuePayment'])->name('ticket.continue-payment');
        Route::post('/ticket/{order}/cancel', [TicketController::class, 'cancel'])->name('ticket.cancel');

        // Visitor organizer browsing
        Route::get('/organizers', [OrganizerController::class, 'index'])->name('organizers.index');
        Route::get('/organizers/{organizer}', [OrganizerController::class, 'show'])->name('organizers.show');
    });
});