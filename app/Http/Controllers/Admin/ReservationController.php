<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Reservation;
use App\Services\ReservationService;

class ReservationController extends Controller
{
    private Reservation $reservation;

    // 一覧画面を表示
    public function index()
    {

        return view('admin.reservation.index', [
            'reservations' => Reservation::latest()->paginate(12),
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    // 予約の詳細画面を表示、メモのアップデート画面
    public function show(Reservation $reservation)
    {
        $planRoom = $reservation->planRooms->first();
        return view('admin.reservation.show', compact('reservation', 'planRoom'));
    }

    // 予約の編集画面を表示
    // public function edit(Reservation $reservation)
    // {
    //     //
    // }

    // 予約の更新
    public function update(Request $request, Reservation $reservation)
    {
        ReservationService::updateReservation($request->all(), $reservation);
        return to_route('admin.reservation.show', $reservation)->with('success', 'メモを更新しました');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Reservation $reservation)
    {
        ReservationService::destroyReservation($reservation);
        return redirect()->route('admin.reservation.index')->with('success', '予約をキャンセルしました');
    }
}
