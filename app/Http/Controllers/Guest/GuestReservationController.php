<?php

namespace App\Http\Controllers\Guest;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\StayingPlan;
use App\Models\Reservation;
use App\Models\ReservationSlotStayingPlan;
use App\Models\ReservationSlot;
use App\Http\Requests\GuestReservationRequest;
use App\Services\ReservationService;
use Carbon\Carbon;



class GuestReservationController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(string $id)
    {
        $reservation_slot_staying_plan = ReservationSlotStayingPlan::find($id);
        return view('guest.reservation-create', compact('reservation_slot_staying_plan'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(GuestReservationRequest $request)
    {
        // $startDay = $request->start_day;
        // $endDay = Carbon::parse($startDay)->addDay()->toDateString();       

        ReservationService::storeReservation($request);

        $reservation_slot_staying_plan = ReservationSlotStayingPlan::find($request->reservation_slot_staying_plan_id);
        $count = $reservation_slot_staying_plan->reservationSlot->stock;
        $reservation_slot_staying_plan->reservationSlot->stock = $count - 1;
        $reservation_slot_staying_plan->reservationSlot->save();

        return redirect()->route('home')->with('success', '予約を完了しました');
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
    public function destroy(string $id)
    {
        //
    }

    public function checkStock($startDay, $endDay, $roomMasterId, $stayingPlanId)
    {
        $startDate = Carbon::parse($startDay);
        $endDate = Carbon::parse($endDay);

        for ($date = $startDate; $date->lte($endDate); $date->addDay()) {
            $stock = ReservationSlot::where('day', $date)
                        ->where('room_master_id', $roomMasterId)
                        ->whereHas('stayingPlans', function($query) use ($stayingPlanId) {
                            $query->where('id', $stayingPlanId); 
                        })
                        ->first();
            if (!$stock || $stock->stock < 1) {
                return response()->json(['message' => 'その期間は泊まれません。選択し直してください', 'status' => 'failed'], 400);
            }
        }

        return response()->json(['message' => '宿泊可能です', 'status' => 'success'], 200);
    }

}
