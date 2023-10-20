<?php

namespace App\Http\Requests;

use Illuminate\Http\Request;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Contracts\Validation\Validator;
use App\Http\Controllers\InquiryController;
use Carbon\Carbon;

class RoomSlotRequest extends FormRequest
{
    // public function rules()
    // {
    //     return [
    //         'room_master_id' =>  "required",
    //         'start_day' => [
    //             'required',
    //             'date',
    //             'date_format:Y-m-d',
    //             'before_or_equal:end_day',
    //         ],
    //         'end_day' => [
    //             'required',
    //             'date',
    //             'date_format:Y-m-d',
    //             'after_or_equal:start_day',
    //         ],
    //         'stock' => ['required','integer', 'max:100'],
    //     ];
    // }

    // public function attributes()
    // {
    //     return [
    //         'room_master_id' =>  "部屋タイプ",
    //         'start_day' =>  "開始日",
    //         'end_day' =>  "終了日",
    //         'stock' => "部屋数",
    //     ];
    // }

    // public function messages()
    // {
    //     return [
    //         'room_master_id.required' =>  ":attributeは必須です。",
    //         'start_day.required' =>  ":attributeは必須です。",
    //         'end_day.required' =>  ":attributeは必須です。",
    //         'stock.integer' => ":attributeは整数で入力してください。",
    //         'stock.max' => ":attributeは200以内で入力してください。",
    //         'start_day.before_or_equal' => ':attributeは:otherと同じかそれ以前の日付である必要があります。',
    //         'start_day.after_or_equal' => ':attributeは今日の日付以降である必要があります。',
    //         'end_day.after_or_equal' => ':attributeは:start_dayと同じかそれ以後の日付である必要があります。',
    //         'end_day.after_or_equal' => ':attributeは今日の日付以降である必要があります。',
    //     ];
    // }
}