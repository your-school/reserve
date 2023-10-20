<?php

namespace App\Services;

use App\Models\RoomSlot;
use Carbon\Carbon;


class RoomSlotService
{
    /**
     *  予約枠情報を登録
     */
    public static function store($request)
    {
        $startDay = Carbon::createFromFormat('Y-m-d', $request->start_day);
        $endDay = Carbon::createFromFormat('Y-m-d', $request->end_day);
        $roomMasterIds = $request->room_type_id;
        // dd($roomMasterIds);

        foreach ($roomMasterIds as $roomMasterId) {
            for ($i = $startDay->copy(); $i->lte($endDay); $i->addDay()) {
                    RoomSlot::create([
                        'room_master_id' => $roomMasterId,
                        'day' => $i->toDateString(),
                        'stock' => $request->stock,
                    ]);
            }
        }
    }

    /**
     * 予約枠情報を更新
     */
    public static function update(object $request, RoomSlot $roomSlot)
    {
        $roomSlot->update([
            'stock' => $request->input('stock'),
        ]);
    }
}
