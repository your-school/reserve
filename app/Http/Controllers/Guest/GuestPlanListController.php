<?php

namespace App\Http\Controllers\Guest;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Plan;
use App\Models\RoomSlot;
use Carbon\Carbon;
use App\Http\Requests\SearchReservationRequest;

class GuestPlanListController extends Controller
{
    public function index()
    {
        $plans = Plan::get();
        foreach ($plans as $plan) {
            $groupedRooms = $plan->roomSlots->groupBy(function ($slot) {
                return $slot->room_master_id;
            });
            $plan->groupedRooms = $groupedRooms;
        }

        // $plans->each(function ($plan) {
        //     $groupedSlots = $plan->roomSlots->groupBy(function ($slot) {
        //         return $slot->room_master_id;
        //     })->map(function ($slotsGroup) use ($plan) {
        //         // 各グループの最初のslotからpriceを取得する
        //         // すべてのslotが同じpriceを持っていると仮定しています。
        //         $price = $plan->roomSlots->where('id', $slotsGroup->first()->id)->first()->pivot->price;

        //         return [
        //             'slots' => $slotsGroup,
        //             'price' => $price,
        //         ];
        //     });

        //     $plan->groupedSlots = $groupedSlots;
        // });

        return view('guest.plan.index', compact('plans'));
    }


    public function show(Plan $plan)
    {
        $groupedRooms = $plan->roomSlots->groupBy(function ($slot) {
            return $slot->room_master_id;
        });
        $plan->groupedRooms = $groupedRooms;
        return view('guest.plan.show', compact('plan'));
    }

    public function showCalender(Plan $plan, int $roomMasterId)
    {
        // whereHasメソッドを使って予約枠を選別。更にwithメソッドでリレーション先のモデルを特定。（pivotで用いる）
        $roomSlots = RoomSlot::whereHas('plans', function ($query) use ($plan) {
            $query->where('plans.id', $plan->id);
        })->with(['plans' => function ($query) use ($plan) {
            $query->where('plans.id', $plan->id);
        }])->where('room_master_id', $roomMasterId)->get();

        // 料金を取得する。（Withメソッドでリレーション先のプランを特定済み）
        foreach ($roomSlots as $roomSlot) {
            $associatedPlan = $roomSlot->plans->first();
            $price = $associatedPlan->pivot->price;
            $roomSlot->price = $price;
            $planRoomId = $associatedPlan->pivot->id;
            $roomSlot->planRoomId = $planRoomId;
        }

        return view('guest.plan.show_calender', compact('plan', 'roomSlots', 'roomMasterId'));
    }

    // プランの検索機能
    public function search(SearchReservationRequest $request)
    {

        $startDate = Carbon::parse($request->input('start_day'));
        $endDate = Carbon::parse($request->input('end_day'));

        $plans = Plan::whereHas('roomSlots', function ($query) use ($startDate, $endDate) {
            $query->whereBetween('day', [$startDate, $endDate]);
        })->get();

        foreach ($plans as $plan) {
            $groupedRooms = $plan->roomSlots->groupBy(function ($slot) {
                return $slot->room_master_id;
            });
            $plan->groupedRooms = $groupedRooms;
        }

        $searchedString = "{$startDate->format('m月d日')} ~ {$endDate->format('m月d日')}";

        // 日付を文字列に変換
        $startDateString = $startDate->toDateString();
        $endDateString = $endDate->toDateString();

        // セッションにフラッシュ
        session()->flash('startDate', $startDateString);
        session()->flash('endDate', $endDateString);


        // ここで、$Plans をビューに渡して表示します
        return view('guest.plan.index', compact('plans', 'searchedString'));
    }
}
