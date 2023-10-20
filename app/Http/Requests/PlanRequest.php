<?php

namespace App\Http\Requests;

use Illuminate\Http\Request;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Contracts\Validation\Validator;
use Carbon\Carbon;

class PlanRequest extends FormRequest
{
    public function rules()
    {
        $rules = [
            'room_master_id' =>  "required",
            'price' => 'array',
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
            'title' => ['required', 'string', 'min:2'],
            'explain' => ['required', 'string'],
            'image' => ['nullable','image','mimes:jpeg,png,jpg,gif,svg','max:2048'],
        ];

        foreach($this->input('room_master_id', []) as $roomId) {
            $rules["price.$roomId"] = 'required|integer|min:1';
        }

        return $rules;
    }

    public function attributes()
    {
        return [
            'room_master_id' =>  "部屋タイプ",
            'start_day' =>  "開始日",
            'end_day' =>  "終了日",
            'title' => "タイトル",
            'price.*' => "料金",
            'explain' => "説明",
            'image' => "画像",
        ];
    }

    public function messages()
    {
        return [
            'room_master_id.required' =>  ":attributeは必須です。",
            'start_day.required' =>  ":attributeは必須です。",
            'end_day.required' =>  ":attributeは必須です。",
            'start_day.before_or_equal' => ':attributeは:otherと同じかそれ以前の日付である必要があります。',
            'start_day.after_or_equal' => ':attributeは今日の日付以降である必要があります。',
            'end_day.after_or_equal' => ':attributeは:start_dayと同じかそれ以後の日付である必要があります。',
            'end_day.after_or_equal' => ':attributeは今日の日付以降である必要があります。',
            'title.required' =>  ":attributeは必須です。",
            'price.required' =>  ":attributeは必須です。",
            'explain.required' =>  ":attributeは必須です。",
            'image.image' => ':attributeは画像ファイルを選択してください。',
            'image.mimes' => ':attributeはjpeg,png,jpg,gif,svgのいずれかのファイルを選択してください。',
            'image.max' => ':attributeは2MB以下のファイルを選択してください。',
        ];
    }
}