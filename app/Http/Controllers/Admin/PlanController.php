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



class PlanController extends Controller
{
    /**
     * Display a listing of the resource.
     */
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
        $startDay = Carbon::parse($request->start_day);
        $endDay = Carbon::parse($request->end_day);
        $roomMasterIds = $request->room_master_id;

        \DB::transaction(static function () use ($request, $roomMasterIds, $startDay, $endDay) {
            // 送信された部屋タイプの料金のみを取得
            $roomInputs = collect($request->input('price'))->filter(function ($value) {
                return !is_null($value);
            });

            $allMatchingRoomSlots = [];

            foreach ($roomMasterIds as $roomMasterId) {
                // 部屋枠が存在するか確認
                $matchingRoomSlots = RoomSlot::where('room_master_id', $roomMasterId)
                ->whereBetween('day', [$startDay, $endDay])
                ->get();

                // 部屋枠が存在しない場合はエラーを返す
                if($matchingRoomSlots->isEmpty()) {
                    return redirect()->back()->with('error', '指定した日付の予約枠が存在しません。');
                }

                // 部屋枠が存在する場合は$allMatchingroomSlotsに追加
                $allMatchingRoomSlots[$roomMasterId] = $matchingRoomSlots;
            }

            // Planテーブルにプラン情報を作成
            $plan = Plan::create([
                'title' => $request->title,
                'explain' => $request->explain,
            ]);

            // 取得したroomMasterIdsに対してforeachループを実行
            foreach ($roomMasterIds as $roomMasterId) {
                // $allMatchingRoomSlotsに格納されているRoomSlotを取テーブルにデータを挿入
                foreach($allMatchingRoomSlots[$roomMasterId] as $roomSlot) {
                    // 中間テーブルの作成
                    PlanRoom::create([
                    'plan_id' => $plan->id,
                    'room_slot_id' => $roomSlot->id,
                    'price' => $roomInputs[$roomMasterId],
                    ]);
                }
            }

            // // PlanImagesテーブルに画像データの挿入
            // if ($request->hasFile('image')) {
            //         // アップロードされたファイルを変数に格納
            //     $upload_file = $request->file('image');

            //     // アップロード先S3フォルダ名
            //     $dir = 'reservesystem';

            //     // バケット内の指定フォルダへアップロード ※putFileはLaravel側でファイル名の一意のIDを自動的に生成してくれます。
            //     $s3_upload = Storage::disk('s3')->putFile('/'.$dir, $upload_file);

            //     // ※オプション（ファイルダウンロード、削除時に使用するS3でのファイル保存名、アップロード先のパスを取得します。）
            //     // アップロードファイルurlを取得
            //     $s3_url = Storage::disk('s3')->url($s3_upload);

            //     // s3_urlからS3でのファイル保存名取得
            //     $s3_upload_file_name = explode("/", $s3_url)[5];

            //     // アップロード先パスを取得 ※ファイルダウンロード、削除で使用します。
            //     $s3_path = $dir.'/'.$s3_upload_file_name;

            //     PlanImages::create([
            //         'image_path' => $upload_file,
            //         '_plan_id' => $Plan->id
            //     ]);
            // }
        });

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

    public function destroy($id)
    {
        $plan = Plan::find($id);

        if (!$Plan) {
            // エラーメッセージやリダイレクトをここで行う
            return redirect()->back()->with('error', '宿泊プランが見つかりませんでした。');
        }

        // 関のデータを削除
        $plan->roomSlots()->detach();

        // 関連するPlanImagesのデータを削除
        foreach ($plan->planImages as $image) {
            // 必要に応じて物理的な画像ファイルも削除することができます
            $image->delete();
        }

        // Planを削除
        $plan->delete();

        // 削除が完了したら、一覧ページなどにリダイレクトする
        return redirect()->route('admin.plan.index')->with('success', '宿泊プランを削除しました。');
    }

}
