<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\RoomSlot;
use App\Models\Plan;
use App\Models\PlanRoom;
use Carbon\Carbon;

class CreateRoomSlotData extends Command
{
    // コマンドのシグネチャ（呼び出し名）
    protected $signature = 'create:room-slot-data';

    // コマンドの説明
    protected $description = 'Create room slot data.';

    // 実行するタスクを記述するメソッド
    public function handle()
    {
        $startDay = Carbon::now()->startOfWeek();
        $endDay = $startDay->copy()->endOfWeek();

        $roomMasterIds = range(1, 4); // 1〜4 のIDを配列として作成
        $prices = [1 => 10000, 2 => 20000, 3 => 30000, 4 => 40000];

        // RoomSlotの作成または取得
        foreach ($roomMasterIds as $roomMasterId) {
            for ($day = $startDay->copy(); $day->lte($endDay); $day->addDay()) {
                RoomSlot::firstOrCreate([
                    'room_master_id' => $roomMasterId,
                    'day' => $day->toDateString(),
                ], [
                    'stock' => 5,
                ]);
            }
        }

        // Planの作成
        $plan = Plan::create([
            'title' => 'コマンドを実行したプラン',
            'explain' => 'これはデフォルトのプラン説明です。',
        ]);

        // PlanRoomの作成
        foreach ($roomMasterIds as $roomMasterId) {
            // 各RoomMasterIdのRoomSlotを取得
            $roomSlots = RoomSlot::where('room_master_id', $roomMasterId)
                ->whereBetween('day', [$startDay, $endDay])
                ->get();

            foreach ($roomSlots as $roomSlot) {
                PlanRoom::create([
                    'plan_id' => $plan->id,
                    'room_slot_id' => $roomSlot->id,
                    'price' => $prices[$roomMasterId],
                ]);
            }
        }

        $this->info('予約枠とプラン情報が正常に作成されました。');
    }
}
