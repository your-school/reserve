<?php

namespace App\Http\Requests;

use Illuminate\Http\Request;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Contracts\Validation\Validator;
use App\Http\Controllers\InquiryController;

class InquiryRequest extends FormRequest
{
    public function rules()
    {
        return [
            'first_name' =>  "required|min:1|max:30",
            'last_name' =>  "required|min:1|max:30",
            'email' =>  "required|max:40",
            'inquiry_category' =>  "required",
            'content' => "required|min:2|max:10000",
        ];
    }

    public function attributes()
    {
        return [
            'first_name' => "氏名",
            'last_name' => "名前",
            'email' => "メールアドレス",
            'inquiry_category' => "お問い合わせ項目",
            'content' => "お問合せ内容",
        ];
    }

    public function messages()
    {
        return [
            'first_name.required' => ":attributeを入力してください",
            'first_name.max' => ":attributeは30文字以内で入力してください",
            'last_name.required' => ":attributeを入力してください",
            'last_name.max' => ":attributeは30文字以内で入力してください",
            'email.required' => ":attributeを入力してください",
            'email.max' => ":attributeは40文字以内で入力してください",
            'inquiry_category.required' => ":attributeを選択してください",
            'content.required' => ":attributeを入力してください",
            'content.max' => ":attributeは10000文字以内で入力してください",
        ];
    }





    protected $redirect = '/inquiry';
}