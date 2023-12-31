<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\RoomSlot;
use App\Models\PlanRoom;
use Carbon\Carbon;

class DeleteExceedRoomSlots extends Command
{
    protected $signature = 'delete:exceed-room-slots';
    protected $description = 'Delete expired room slots and associated plan rooms.';

    public function handle()
    {
        // 今日の日付より前のRoomSlotを取得
        $expiredRoomSlots = RoomSlot::where('day', '<', Carbon::today()->toDateString())->get();

        foreach ($expiredRoomSlots as $roomSlot) {
            // 関連するPlanRoomを削除
            PlanRoom::where('room_slot_id', $roomSlot->id)->delete();

            // RoomSlotを削除
            $roomSlot->delete();
        }

        $this->info('期限切れの予約枠を削除しました');
    }
}
