<?php

namespace App\Http\Requests;

use Illuminate\Http\Request;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Contracts\Validation\Validator;
use Carbon\Carbon;

class GuestReservationRequest extends FormRequest
{
    public function rules()
    {
        return [
            'first_name' =>  ['required','string', 'min:1'],
            'last_name' =>  ['required','string', 'min:1'],
            'number_of_people' =>  ['required','integer', 'min:1'],
            'email' =>  ['required','string', 'min:1'],
            'phone_number' =>  ['required','string', 'min:1'],
            'post_code' =>  ['required','string', 'min:1'],
            'address' =>  ['required','string', 'min:1'],
            'message' =>  "nullable",
            'reservation_slot_staying_plan_id' =>  ['required','string'],
            'start_day' =>  ['required','date'],
        ];
    }

    public function attributes()
    {
        return [
            'first_name' =>  "苗字",
            'last_name' =>  "名前",
            'number_of_people' =>  "宿泊人数",
            'email' =>  "メールアドレス",
            'phone_number' =>  "電話番号",
            'post_code' =>  "郵便番号",
            'address' =>  "住所",
            'message' =>  "メモ",
        ];
    }

}