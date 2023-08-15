<?php

namespace App\Http\Controllers;

use App\Http\Requests\InquiryRequest;
use App\Models\Inquiries;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Mail\ToCustomerMail;
use App\Mail\ToAdminMail;

class InquiryController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $inquiries = Inquiries::latestOrder()->paginate(10);

        return view('admin.admin-inquiries', compact('inquiries'));
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
        Inquiries::create([
            'first_name' => $request['first_name'],
            'last_name' => $request['last_name'],
            'email' => $request['email'],
            'inquiry_category' => $request['inquiry_category'],
            'content' => $request['content'],
            'status' => '0',
        ]);

        $full_name = $request['first_name'] . ' ' . $request['last_name'];

        \Mail::to($request->email) -> send(new ToCustomerMail($request['content'], $full_name));
        \Mail::to('hello@example.com') -> send(new ToAdminMail($request['content'], $full_name));


        return redirect()->route('home')->with('success', 'お問合せが完了しました。返答までしばしお待ちください。');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $inquiry = Inquiries::find($id);

        return view('admin.admin-inquiries-detail', compact('inquiry'));
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

        $inquiry->status = $request['status'];
        $inquiry->save();

        return redirect()->route('inquiries.show', $id)->with('success', 'ステータスを変更しました。');
    }


    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
