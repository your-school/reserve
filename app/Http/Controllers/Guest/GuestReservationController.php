<?php

namespace App\Http\Controllers\Guest;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\StayingPlan;
use App\Models\Reservation;
use App\Models\PlanRoom;
use App\Models\RoomSlot;
use App\Http\Requests\GuestReservationRequest;
use App\Services\ReservationService;
use Carbon\Carbon;
use GuzzleHttp\Client;



class GuestReservationController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    // 予約画面を表示
    public function create(string $planRoomId)
    {
        $planRoom = PlanRoom::find($planRoomId);
        return view('guest.reservation.create', compact('planRoom'));
    }

    // 予約確認画面を表示
    public function confirm(Request $request)
    {
        // session()->put($request->all());
        // flashは連想配列で受け取れないためForeachで回して保存
        foreach ($request->all() as $key => $value) {
            session()->flash($key, $value);
        }
        return view('guest.reservation.confirm', [
            'request' => $request,
            'planRoom' => PlanRoom::find($request->plan_room_id),
        ]);
    }

    // 予約の保存
    public function store(Request $request)
    {
        ReservationService::storeReservation(session()->all());

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

    public function checkStock($startDay, $endDay, $roomMasterId, $planId)
    {
        // \DB::enableQueryLog();
        $startDate = Carbon::parse($startDay);
        $endDate = Carbon::parse($endDay);

        for ($date = $startDate; $date->lte($endDate); $date->addDay()) {
            $stock = RoomSlot::where('day', $date)
                ->where('room_master_id', $roomMasterId)
                ->whereHas('plans', function ($query) use ($planId) {
                    $query->where('plans.id', $planId);
                })
                ->first();
            if (!$stock || $stock->stock < 1) {
                return response()->json(['message' => 'その期間は泊まれません。選択し直してください', 'status' => 'failed'], 400);
            }
        }
        // $queries = \DB::getQueryLog();
        // \Log::info($queries);

        return response()->json(['message' => '宿泊可能です', 'status' => 'success'], 200);
    }

    public function getAddress($zipCode)
    {
        $client = new Client();
        $response = $client->get('http://zipcloud.ibsnet.co.jp/api/search', [
            'query' => [
                'zipcode' => $zipCode
            ]
        ]);

        $data = json_decode($response->getBody(), true);

        // 外部サービスのレスポンスに応じてデータを整形
        $address = $data['results'][0]['address1'] . $data['results'][0]['address2'] . $data['results'][0]['address3'];

        return response()->json(['address' => $address]);
    }
}
