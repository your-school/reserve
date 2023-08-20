<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\StayingPlan;
use App\Models\Reservation;
use App\Models\ReservationSlotStayingPlan;
use App\Http\Requests\GuestReservationRequest;
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
        $reservation_slot_staying_plan = ReservationSlotStayingPlan::find($request->reservation_slot_staying_plan_id);

        $startDay = $request->start_day;
        $endDay = Carbon::parse($startDay)->addDay()->toDateString();       

        Reservation::create([
            'reservation_slot_staying_plan_id' => $reservation_slot_staying_plan['id'],
            'first_name' =>  $request->first_name,
            'last_name' =>  $request->last_name,
            'number_of_people' =>  $request->number_of_people,
            'email' =>  $request->email,
            'phone_number' =>  $request->phone_number,
            'post_code' =>  $request->post_code,
            'address' =>  $request->address,
            'message' =>  $request->message,
            'start_day' => $startDay,
            'end_day' => $endDay,
        ]);

        $reservationSlot=$reservation_slot_staying_plan->stayingPlan->first();
        $reservationSlot->id = $reservationSlot['id'];

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
}
