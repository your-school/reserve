<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

use App\Http\Controllers\InquiryController;
use App\Http\Controllers\ReservationSlotController;
use App\Http\Controllers\StayingPlanController;
use App\Http\Controllers\ReservationController;
use App\Http\Controllers\Guest\GuestReservationController;
use App\Http\Controllers\Guest\GuestPlanListController;


use App\Models\Reservation;
use App\Models\ReservationSlot;

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

Route::get('/', function () {
    return view('home');
})->name('home');

Route::get('/access_guide', function () {
    return view('guest.access-guide');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/admin_home', function () {
        return view('admin.home');
    })->name('admin_home');
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
    Route::get('/inquiries/show/{id}', [InquiryController::class, 'show'])->name('inquiries.show');
    Route::patch('/inquiries/update/{id}', [InquiryController::class, 'update'])->name('inquiries.update');
    Route::get('/inquiries', [InquiryController::class, 'index'])->name('inquiries.index');
    Route::resource('reservation_slot', ReservationSlotController::class);
    Route::resource('staying_plan', StayingPlanController::class);
    Route::resource('reservation', ReservationController::class);


});

Route::middleware('guest')->group(function () {
    Route::get('/inquiry', function () {
        return view('guest.inquiry');
    })->name('inquiry');

    Route::post('/inquiry', function () {
        return redirect()->route('home')->with('success', 'お問い合わせを受け付けました。');
    })->name('inquiry.send');

    Route::post('/inquiry/store', [InquiryController::class, 'store'])
        ->name('inquiry.store');

    Route::get('/plan/search', [GuestPlanListController::class, 'search'])->name('plan.search');
    Route::resource('plan', GuestPlanListController::class);
    Route::get('reservation/create/{id}', [GuestReservationController::class, 'create'])->name('reservation.create');
    Route::resource('reservation', GuestReservationController::class)->except('create');
        
});


require __DIR__.'/auth.php';
