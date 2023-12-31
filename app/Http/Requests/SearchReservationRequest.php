<?php

namespace App\Http\Requests;

use Illuminate\Http\Request;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Contracts\Validation\Validator;
use App\Http\Controllers\InquiryController;
use Carbon\Carbon;

class SearchReservationRequest extends FormRequest
{
    public function rules()
    {
        return [
            'start_day' => [
                'required',
                'date',
                'before_or_equal:end_day',
            ],
            'end_day' => [
                'required',
                'date',
                'after_or_equal:start_day',
            ],
        ];
    }

    public function attributes()
    {
        return [
            'start_day' =>  "開始日",
            'end_day' =>  "終了日",
        ];
    }

    public function messages()
    {
        return [
            'start_day.before_or_equal' => ':attributeは:otherと同じかそれ以前の日付である必要があります。',
            'start_day.after_or_equal' => ':attributeは今日の日付以降である必要があります。',
            'end_day.after_or_equal' => ':attributeは:start_dayと同じかそれ以後の日付である必要があります。',
            'end_day.after_or_equal' => ':attributeは今日の日付以降である必要があります。',
        ];
    }
}
