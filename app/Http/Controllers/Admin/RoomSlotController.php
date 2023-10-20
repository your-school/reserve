<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\RoomSlot;
use App\Models\RoomMaster;
use App\Http\Requests\RoomSlotRequest;
use Carbon\Carbon;
use App\Services\RoomSlotService;


class RoomSlotController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
    $roomTypes = RoomMaster::get();
    $slots = [];

    foreach ($roomTypes as $roomType) {
        $roomSlots = RoomSlot::where('room_master_id', $roomType['id'])->get();
        $slots[$roomType['id']] = $roomSlots;
    }
    return view('admin.room_slot.index', compact( 'roomTypes', 'slots'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.room_slot.create', [
            'roomTypes' => RoomMaster::get(),
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(RoomSlotRequest $request)
    {
        RoomSlotService::store($request);
        
        return redirect()->route('admin.room_slot.index')->with('success', '部屋枠を作成しました。');
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
    public function update(Request $request, RoomSlot $roomSlot)
    {
        RoomSlotService::update($request, $roomSlot);
        
        return redirect()->route('admin.room_slot.index')->with('success', '部屋枠の数を変更しました。');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(RoomSlot $roomSlot)
    {
        $roomSlot->delete();

        return redirect()->route('admin.room_slot.index')->with('success', '削除しました');
    }
}
