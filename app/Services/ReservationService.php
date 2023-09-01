<?php

namespace App\Services;

use App\Models\Reservation;
use Carbon\Carbon;


class ReservationService
{
    /**
     *  倉庫マスタを登録
     */
    public static function storeReservation($request): Reservation
    {
        $startDay = $request->start_day;
        $endDay = Carbon::parse($startDay)->addDay()->toDateString();      

        return Reservation::create([
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
    }

    /**
     * 倉庫マスタを更新
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