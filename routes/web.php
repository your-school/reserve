<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

use App\Http\Controllers\Admin\InquiryController;
use App\Http\Controllers\Admin\RoomSlotController;
use App\Http\Controllers\Admin\PlanController;
use App\Http\Controllers\Admin\ReservationController;
use App\Http\Controllers\Guest\GuestReservationController;
use App\Http\Controllers\Guest\GuestPlanListController;


Route::get('/', function () {
    return view('home');
})->name('home');

Route::get('/access_guide', function () {
    return view('guest.access-guide');
});


// 管理者側
Route::middleware('auth')->prefix('admin')->name('admin.')->group(function () {
    Route::get('/home', function () {
        return view('admin.home');
    })->name('home');

    // プロフィール編集
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    // お問合せ対応
    Route::get('/inquiries/show/{id}', [InquiryController::class, 'show'])->name('inquiries.show');
    Route::patch('/inquiries/update/{id}', [InquiryController::class, 'update'])->name('inquiries.update');
    Route::get('/inquiries', [InquiryController::class, 'index'])->name('inquiries.index');

    // 予約枠
    Route::resource('room_slot', RoomSlotController::class);

    // プラン
    Route::resource('plan', PlanController::class);

    // 予約情報
    Route::post('/reservation/cancel/{reservation}', [ReservationController::class, 'cancel'])->name('reservation.cancel');
    Route::post('/reservation/check_in/{reservation}', [ReservationController::class, 'checkIn'])->name('reservation.check_in');
    Route::get('/reservation/today', [ReservationController::class, 'todayReservation'])->name('reservation.today');
    Route::get('/reservation/next_day', [ReservationController::class, 'nextDayReservation'])->name('reservation.nextday');
    Route::post('/reservation/search', [ReservationController::class, 'searchReservation'])->name('reservation.search');
    Route::resource('reservation', ReservationController::class);
});

Route::middleware('guest')->group(function () {

    // お問い合わせ投稿
    Route::get('/inquiry', function () {
        return view('guest.inquiry');
    })->name('inquiry');
    Route::post('/inquiry', function () {
        return redirect()->route('home')->with('success', 'お問い合わせを受け付けました。');
    })->name('inquiry.send');
    Route::post('/inquiry/store', [InquiryController::class, 'store'])
        ->name('inquiry.store');

    // プランの閲覧
    Route::get('/plan/search', [GuestPlanListController::class, 'search'])->name('plan.search');
    Route::get('/plan/show_calender/{plan}/{roomMasterId}', [GuestPlanListController::class, 'showCalender'])->name('plan.showCalender');
    Route::resource('plan', GuestPlanListController::class);

    // 予約の申し込み
    Route::get('reservation/create/{planRoomId}', [GuestReservationController::class, 'create'])->name('reservation.create');
    Route::post('reservation/confirm', [GuestReservationController::class, 'confirm'])->name('reservation.confirm');
    Route::resource('reservation', GuestReservationController::class)->except('create');
});

// アドミンの開発環境ログイン
Route::get('admin_dev_login', function () {
    abort_unless(app()->environment('local'), 403);
    auth()->login(App\Models\User::first());
    return redirect()->to('/admin/home');
})->name('admin_dev_login');


require __DIR__ . '/auth.php';
