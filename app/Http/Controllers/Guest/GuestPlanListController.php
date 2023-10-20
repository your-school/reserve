<?php

namespace App\Http\Controllers\Guest;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Plan;


class GuestPlanListController extends Controller
{
    /**
     * Display a listing of the resource.
     */
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

        return view('guest.plan-list', compact('plans'));
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

    /**
     * Display the specified resource.
     */
    public function show(Plan $plan)
    {
        $groupedRooms = $plan->roomSlots->groupBy(function ($slot) {
            return $slot->room_master_id;
        });
        $plan->groupedRooms = $groupedRooms;
        return view('guest.plan-detail', compact('plan'));
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
    public function destroy(string $id)
    {
        //
    }

    public function search(Request $request)
    {
        
        $startDate = $request->input('start_day');
        $endDate = $request->input('end_day');

        $plans = Plan::whereHas('roomSlots', function ($query) use ($startDate, $endDate) {
            $query->whereBetween('day', [$startDate, $endDate]);
        })->get();

        // ここで、$Plans をビューに渡して表示します
        return view('guest.plan-list', compact('plans'));
    }
}
