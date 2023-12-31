<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\InquiryRequest;
use App\Models\Inquiries;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Mail\ToCustomerMail;
use App\Mail\ToAdminMail;
use App\Services\InquiryService;

class InquiryController extends Controller
{
    // お問合せ一覧
    public function index()
    {
        $inquiries = Inquiries::latestOrder()->paginate(10);

        return view('admin.inquiries.index', compact('inquiries'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    // お問合せ投稿（ゲスト側）
    public function store(InquiryRequest $request)
    {
        InquiryService::store($request);

        return redirect()->route('home')->with('success', 'お問合せが完了しました。返答までしばしお待ちください。');
    }

    // お問い合わせ詳細
    public function show(string $id)
    {
        $inquiry = Inquiries::find($id);

        return view('admin.inquiries.show', compact('inquiry'));
    }

    // /お問合せのステータス変更
    public function update(Request $request, string $id)
    {
        $inquiry = Inquiries::find($id);
        InquiryService::update($request, $inquiry);

        return redirect()->route('admin.inquiries.show', $id)->with('success', 'ステータスを変更しました。');
    }


    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
