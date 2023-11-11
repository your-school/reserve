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

    public function __construct(Plan $plan)
    {
        $this->plan = $plan;
    }


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

    // 新規作成画面を表示
    public function create()
    {

        return view('admin.plan.create');
    }

    // 新規作成画面からの登録処理
    public function store(PlanRequest $request)
    {
        // dd($request->all());
        PlanService::storePlan($request);

        return redirect()->route('admin.plan.index');
    }

    public function show(string $id)
    {
        //
    }

    // 編集画面を表示
    public function edit(Plan $plan)
    {
        $roomSlots = $plan->roomSlots()->get();

        $startDay = $roomSlots->min('day');
        $endDay = $roomSlots->max('day');

        // RoomSlotをEager Loadし、その後フィルタリングして、
        // 各room_master_idごとに一つだけ取得する。
        $prices = $roomSlots->groupBy('room_master_id')
            ->mapWithKeys(function ($roomSlots, $roomMasterId) {
                // groupByがコレクションを返すため、最初のRoomSlotを取得します。
                return [$roomMasterId => $roomSlots->first()->pivot->price];
            });

        // viewにplanと価格情報を渡す。
        return view('admin.plan.edit', compact('plan', 'prices', 'startDay', 'endDay'));
    }


    // 更新処理
    public function update(Request $request, Plan $plan)
    {
        PlanService::updatePlan($request, $plan);

        return redirect()->route('admin.plan.index')->with('success', '宿泊プランを更新しました。');
    }

    // 削除処理
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
