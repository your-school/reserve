<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\StayingPlan;


class GuestPlanListController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $stayingPlans = StayingPlan::with('reservationSlots')->get();

        $stayingPlans->each(function ($stayingPlan) {
            $groupedSlots = $stayingPlan->reservationSlots->groupBy(function ($slot) {
                return $slot->room_master_id;
            })->map(function ($slotsGroup) use ($stayingPlan) {
                // 各グループの最初のslotからpriceを取得する
                // すべてのslotが同じpriceを持っていると仮定しています。
                $price = $stayingPlan->reservationSlots->where('id', $slotsGroup->first()->id)->first()->pivot->price;

                return [
                    'slots' => $slotsGroup,
                    'price' => $price,
                ];
            });

            $stayingPlan->groupedSlots = $groupedSlots;
        });

        return view('guest.plan-list', compact('stayingPlans'));
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
    public function show(string $id)
    {
        $stayingPlan = StayingPlan::find($id);

        return view('guest.plan-detail', compact('stayingPlan'));
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

        $stayingPlans = StayingPlan::whereHas('reservationSlots', function ($query) use ($startDate, $endDate) {
            $query->whereBetween('day', [$startDate, $endDate]);
        })->get();

        // ここで、$stayingPlans をビューに渡して表示します
        return view('guest.plan-list', compact('stayingPlans'));
    }
}
