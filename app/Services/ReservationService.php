<?php

namespace App\Services;

use App\Models\PlanRoom;
use App\Models\PlanRoomReservation;
use App\Models\RoomSlot;
use App\Models\Reservation;
use Carbon\Carbon;


class ReservationService
{
    /**
     *  予約情報を登録
     */
    public static function storeReservation($request)
    {
        $startDay = $request->start_day;
        $endDay = $request->end_day;
        $reservedPlan = PlanRoom::find($request->plan_room_id)->plan;
        $reservedRoomId = PlanRoom::find($request->plan_room_id)->room->room_master_id;

        \DB::transaction(function () use ($request, $startDay, $endDay, $reservedPlan, $reservedRoomId) {
            // $reservation = self::createReservation($request, $startDay, $endDay);
            // $reservation->planRooms()->attach($request->plan_room_id, ['price' => $request->price]);
            $reservation = Reservation::create([
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

            // ltメソッドは、引数のCarbonインスタンスよりも小さいかどうかを判定する。
            // for ($day = $startDay; $day->lt($endDay); $day->addDay()) {

            // lteメソッドは、引数のCarbonインスタンスよりも小さいか、等しいかどうかを判定する。$startDayと$endDayの前日が同じ日付でも、ループが1回実行される
            for ($day = $startDay; $day->lte($endDay->subDay()); $day->addDay()) {
                // 現在の日付の予約枠を取得
                $nowRoomSlot = RoomSlot::where('room_master_id', $reservedRoomId)->where('day', $day)->first();
                // 現在の中間テーブルを取得
                $nowPlanRoom = PlanRoom::where('plan_id', $reservedPlan->id)->where('room_id', $nowRoomSlot->id)->first();

                // 予約枠と宿泊プランを紐付ける中間テーブルに保存
                PlanRoomReservation::create([
                    'plan_room_id' => $nowPlanRoom->id,
                    'reservation_id' => $reservation->id,
                ]);

                // 予約枠の在庫を減らす
                $count = $nowRoomSlot->stock;
                dump($count);
                $nowRoomSlot->stock = $count - 1;
                dd($nowRoomSlot->stock);
                $nowRoomSlot->save();
            }
        });
    }

    /**
     * 予約情報を更新
     */
    public function updateReservation(array $request, Reservation $Reservation): Reservation
    {
        $Reservation->mst_affiliation_id = $request['mst_affiliation_id'];
        $Reservation->number = $request['number'];
        $Reservation->name = $request['name'];

        $Reservation->save();
        return $Reservation;
    }
}
