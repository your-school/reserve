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

        $plans->each(function ($plan) {
            $groupedSlots = $plan->roomSlots->groupBy(function ($slot) {
                return $slot->room_master_id;
            })->map(function ($slotsGroup) use ($plan) {
                // 各グループの最初のslotからpriceを取得する
                // すべてのslotが同じpriceを持っていると仮定しています。
                $price = $plan->roomSlots->where('id', $slotsGroup->first()->id)->first()->pivot->price;
                return [
                    'slots' => $slotsGroup,
                    'price' => $price
                ];
            });

            $plan->groupedSlots = $groupedSlots;
        });

        $plans->each(function ($plan) {
            $groupedSlots = $plan->roomSlots->groupBy('room_master_id')->map(function ($slotsGroup) use ($plan) {
                // 各グループのroom_master_idを取得
                $roomMasterId = $slotsGroup->first()->room_master_id;

                // 各グループごとに最大価格を取得
                $maxPrice = PlanRoom::where('plan_id', $plan->id)
                    ->whereHas('roomSlot', function ($query) use ($roomMasterId) {
                        $query->where('room_master_id', $roomMasterId);
                    })
                    ->max('price');

                // 各グループごとに最小価格を取得
                $minPrice = PlanRoom::where('plan_id', $plan->id)
                    ->whereHas('roomSlot', function ($query) use ($roomMasterId) {
                        $query->where('room_master_id', $roomMasterId);
                    })
                    ->min('price');

                return [
                    'slots' => $slotsGroup,
                    'maxPrice' => $maxPrice,
                    'minPrice' => $minPrice
                ];
            });

            $plan->groupedSlots = $groupedSlots;
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
    public function update(PlanRequest $request, Plan $plan)
    {
        PlanService::updatePlan($request, $plan);

        return redirect()->route('admin.plan.index')->with('success', '宿泊プランを更新しました。');
    }

    // 料金編集画面を表示
    public function chargeEdit(int $planId, int $roomMasterId)
    {
        $plan = Plan::find($planId);

        $planRooms = PlanRoom::where('plan_id', $planId)
            ->whereHas('roomSlot', function ($query) use ($roomMasterId) {
                $query->where('room_master_id', $roomMasterId);
            })->get();

        return view('admin.plan.charge_edit', compact('planRooms'));
    }

    // 料金更新処理
    public function chargeUpdate(Request $request, PlanRoom $planRoom)
    {
        PlanService::updatePlanCharge($request, $planRoom);

        return redirect()->back()->with('success', '料金を更新しました。');
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
