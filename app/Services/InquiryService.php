<?php

namespace App\Services;

use App\Models\Inquiries;
use Carbon\Carbon;
use App\Mail\ToCustomerMail;
use App\Mail\ToAdminMail;


class InquiryService
{
    /**
     *  お問合せ情報を登録
     */
    public static function store($request)
    {
        Inquiries::create([
            'first_name' => $request['first_name'],
            'last_name' => $request['last_name'],
            'email' => $request['email'],
            'inquiry_category' => $request['inquiry_category'],
            'content' => $request['content'],
            'status' => '0',
            'created_at' => Carbon::now(),
            'updated_at' => NULL,
        ]);

        $full_name = $request['first_name'] . ' ' . $request['last_name'];

        \Mail::to($request->email)->send(new ToCustomerMail($request['content'], $full_name));
        \Mail::to('hello@example.com')->send(new ToAdminMail($request['content'], $full_name));
    }

    /**
     * お問合せ情報を更新
     */
    public static function update(object $request, Inquiries $inquiry)
    {
        $inquiry->update([
            'status' => $request->status,
        ]);
    }
}
