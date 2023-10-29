<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Requests\PlanRequest;
use Carbon\Carbon;
use App\Models\Plan;
use App\Models\PlanImages;
use App\Models\PlanRoom;
use App\Models\RoomSlot;
use Illuminate\Support\Facades\DB;
use Storage;
use App\Services\PlanService;



class PlanController extends Controller
{
    private Plan $plan;

    // 一覧画面を表示
    public function index()
    {
        $plans = Plan::with('roomSlots')->get();

        $plans->each(function ($Plan) {
            $groupedSlots = $Plan->roomSlots->groupBy(function ($slot) {
                return $slot->room_master_id;
            })->map(function ($slotsGroup) use ($Plan) {
                // 各グループの最初のslotからpriceを取得する
                // すべてのslotが同じpriceを持っていると仮定しています。
                $price = $Plan->roomSlots->where('id', $slotsGroup->first()->id)->first()->pivot->price;
                return [
                    'slots' => $slotsGroup,
                    'price' => $price
                ];
            });

            $Plan->groupedSlots = $groupedSlots;
        });

        return view('admin.plan.index', compact('plans'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {

        return view('admin.plan.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(PlanRequest $request)
    {
        PlanService::store($request);

        return redirect()->route('admin.plan.index')->with('success', '宿泊プランを作成しました。');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
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
        //
    }

    public function destroy(Plan $plan)
    {
        if (!$plan) {
            // エラーメッセージやリダイレクトをここで行う
            return redirect()->back()->with('error', '宿泊プランが見つかりませんでした。');
        }

        // Planを削除
        $plan->delete();

        // 削除が完了したら、一覧ページなどにリダイレクトする
        return redirect()->route('admin.plan.index')->with('success', '宿泊プランを削除しました。');
    }
}
