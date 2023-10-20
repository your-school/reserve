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
    /**
     * Display a listing of the resource.
     */
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

    /**
     * Store a newly created resource in storage.
     */
    public function store(InquiryRequest $request)
    {
        InquiryService::store($request);

        return redirect()->route('home')->with('success', 'お問合せが完了しました。返答までしばしお待ちください。');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $inquiry = Inquiries::find($id);

        return view('admin.inquiries.show', compact('inquiry'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
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
