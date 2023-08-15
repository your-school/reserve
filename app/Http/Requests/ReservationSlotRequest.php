<?php

namespace App\Http\Requests;

use Illuminate\Http\Request;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Contracts\Validation\Validator;
use App\Http\Controllers\InquiryController;
use Carbon\Carbon;

class ReservationSlotRequest extends FormRequest
{
    public function rules()
    {
        return [
            'reservation_id' =>  "",
            'room_master_id' =>  "required",
            'start_day' => [
                'required',
                'date',
                'date_format:Y-m-d',
                'before_or_equal:end_day',
                'after_or_equal:' . Carbon::today()->toDateString(),
            ],
            'end_day' => [
                'required',
                'date',
                'date_format:Y-m-d',
                'after_or_equal:start_day',
                'after_or_equal:' . Carbon::today()->toDateString(),
            ],
            'room_count' => ['required','integer', 'max:200'],
        ];
    }

    public function attributes()
    {
        return [
            'reservation_id' =>  "予約ID",
            'room_master_id' =>  "部屋タイプ",
            'start_day' =>  "開始日",
            'end_day' =>  "終了日",
            'room_count' => "部屋数",
        ];
    }

    public function messages()
    {
        return [
            'reservation_id.required' =>  ":attributeは必須です。",
            'room_master_id.required' =>  ":attributeは必須です。",
            'start_day.required' =>  ":attributeは必須です。",
            'end_day.required' =>  ":attributeは必須です。",
            'room_count.integer' => ":attributeは整数で入力してください。",
            'room_count.max' => ":attributeは200以内で入力してください。",
            'start_day.before_or_equal' => ':attributeは:otherと同じかそれ以前の日付である必要があります。',
            'start_day.after_or_equal' => ':attributeは今日の日付以降である必要があります。',
            'end_day.after_or_equal' => ':attributeは:start_dayと同じかそれ以後の日付である必要があります。',
            'end_day.after_or_equal' => ':attributeは今日の日付以降である必要があります。',
        ];
    }
}