<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Reservation;
use App\Services\ReservationService;
use Carbon\Carbon;
use App\Models\RoomSlot;
use App\Http\Requests\SearchReservationRequest;

class ReservationController extends Controller
{
    private Reservation $reservation;

    // 一覧画面を表示
    public function index()
    {
        $reservations = Reservation::latest()->paginate(30);

        foreach ($reservations as $reservation) {
            $roomName = RoomSlot::whereHas('planRooms.reservations', function ($query) use ($reservation) {
                $query->where('reservations.id', $reservation->id);
            })->first()->roomMaster->name;
            $reservation->roomName = $roomName;
        }
        return view('admin.reservation.index', [
            'reservations' => $reservations,
        ]);
    }

    // 予約の詳細画面を表示、メモのアップデート画面
    public function show(Reservation $reservation)
    {
        $planRoom = $reservation->planRooms->first();
        return view('admin.reservation.show', compact('reservation', 'planRoom'));
    }

    // 管理者側のメモの更新
    public function update(Request $request, Reservation $reservation)
    {
        ReservationService::updateReservation($request->all(), $reservation);
        return to_route('admin.reservation.show', $reservation)->with('success', 'メモを更新しました');
    }

    // チェックイン済みにする
    public function checkIn(Reservation $reservation)
    {
        ReservationService::checkInReservation($reservation);
        return to_route('admin.reservation.index', $reservation)->with('success', 'チェックインしました');
    }

    // チェックイン済みにする
    public function cancel(Reservation $reservation)
    {
        ReservationService::cancelReservation($reservation);
        return to_route('admin.reservation.index', $reservation)->with('success', 'キャンセルしました');
    }

    // プランの検索機能
    public function searchReservation(SearchReservationRequest $request)
    {
        $startDate = Carbon::parse($request->input('start_day'));
        $endDate = Carbon::parse($request->input('end_day'));

        $reservations = Reservation::whereBetween('start_day', [$startDate, $endDate])->get();

        foreach ($reservations as $reservation) {
            $roomName = RoomSlot::whereHas('planRooms.reservations', function ($query) use ($reservation) {
                $query->where('reservations.id', $reservation->id);
            })->first()->roomMaster->name;
            $reservation->roomName = $roomName;
        }

        $searchedString = "{$startDate->format('m月d日')} ~ {$endDate->format('m月d日')}";

        // 日付を文字列に変換
        $startDateString = $startDate->toDateString();
        $endDateString = $endDate->toDateString();

        // セッションにフラッシュで保存
        session()->flash('startDate', $startDateString);
        session()->flash('endDate', $endDateString);


        // ここで、$reservations をビューに渡して表示します
        return view('admin.reservation.index', compact('reservations', 'searchedString'));
    }

    // プランの検索機能
    public function todayReservation()
    {
        $startDate = Carbon::today();
        $reservations = Reservation::where('start_day', $startDate)->get();

        foreach ($reservations as $reservation) {
            $roomName = RoomSlot::whereHas('planRooms.reservations', function ($query) use ($reservation) {
                $query->where('reservations.id', $reservation->id);
            })->first()->roomMaster->name;
            $reservation->roomName = $roomName;
        }

        $searchedString = "本日";

        return view('admin.reservation.index', compact('reservations', 'searchedString'));
    }

    // プランの検索機能
    public function nextDayReservation()
    {
        $startDate = Carbon::today()->addDay();
        $reservations = Reservation::where('start_day', $startDate)->get();

        foreach ($reservations as $reservation) {
            $roomName = RoomSlot::whereHas('planRooms.reservations', function ($query) use ($reservation) {
                $query->where('reservations.id', $reservation->id);
            })->first()->roomMaster->name;
            $reservation->roomName = $roomName;
        }

        $searchedString = "明日";

        return view('admin.reservation.index', compact('reservations', 'searchedString'));
    }

    // 予約の削除
    // public function destroy(Reservation $reservation)
    // {
    //     ReservationService::destroyReservation($reservation);
    //     return redirect()->route('admin.reservation.index')->with('success', '予約を削除しました');
    // }
}
