<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\ReservationSlot;
use App\Http\Requests\ReservationSlotRequest;
use Carbon\Carbon;

class ReservationSlotController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        // 各部屋タイプに対応する予約枠を取得する
    $roomTypes = [
        '1' => 'シングルルーム',
        '2' => 'ツインルーム',
        '3' => 'デラックスルーム',
        '4' => 'キングルーム',
    ];
    
    $slots = [];
    foreach ($roomTypes as $id => $type) {
        $slotsByDay = ReservationSlot::where('room_master_id', $id)
            ->where('day', '>=', Carbon::today())
            ->orderBy('day', 'asc')
            ->get()
            ->groupBy('day'); // 日時でグループ化
        
        $slots[$type] = $slotsByDay;
    }
    
    return view('admin.reservation-slot', compact('slots', 'roomTypes'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.reservation-slot-create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(ReservationSlotRequest $request)
    {
        $startDay = Carbon::createFromFormat('Y-m-d', $request->start_day);
        $endDay = Carbon::createFromFormat('Y-m-d', $request->end_day);
        $roomMasterIds = $request->room_master_id;
        $roomCount = $request->room_count;

        foreach ($roomMasterIds as $roomMasterId) {
            for ($i = $startDay->copy(); $i->lte($endDay); $i->addDay()) {
                for ($j = 0; $j < $roomCount; $j++) {
                    ReservationSlot::create([
                        'reservation_id' => null,
                        'room_master_id' => $roomMasterId,
                        'day' => $i->toDateString(),
                        'cancel' => null,
                    ]);
                }
            }
        }

        return redirect()->route('reservation_slot.index')->with('success', '部屋枠を作成しました。');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(ReservationSlot $reservationSlot)
    {
        $reservationSlot->delete();

        return redirect()->route('reservation_slot.index')->with('success', '削除しました');
    }

    public function deleteByDate($room_master_id, Request $request)
    {
        $date = $request->input('date');
    
        // reservation_idがNULLのデータのみ削除
        ReservationSlot::where('day', $date)
            ->where('room_master_id', $room_master_id)
            ->whereNull('reservation_id')
            ->first()
            ->delete();
    
        return redirect()->route('reservation_slot.index')->with('success', '日時データを削除しました。');
    }
    
}
