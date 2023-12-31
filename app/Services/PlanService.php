<?php

namespace App\Services;

use App\Models\RoomSlot;
use Carbon\Carbon;
use App\Models\Plan;
use App\Models\PlanRoom;
use App\Models\PlanImages;
use Storage;
use Illuminate\Http\Request;





class PlanService
{
    // プラン情報を登録
    public static function storePlan($request)
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
                if ($matchingRoomSlots->isEmpty()) {
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

            foreach ($allMatchingRoomSlots as $roomMasterId => $matchingRoomSlots) {
                // 部屋枠の数だけプラン部屋テーブルにプラン情報を作成
                foreach ($matchingRoomSlots as $matchingRoomSlot) {
                    PlanRoom::create([
                        'plan_id' => $plan->id,
                        'room_slot_id' => $matchingRoomSlot->id,
                        'price' => $roomInputs[$roomMasterId],
                    ]);
                }
            }

            // PlanImagesテーブルに画像データの挿入
            if ($request->hasFile('images')) {
                // アップロードされたファイルを変数に格納
                foreach ($request->file('images') as $upload_file) {
                    // ディレクトリ名
                    $dir = 'images';
                    // アップロードされたファイル名を取得
                    $file_name = $upload_file->getClientOriginalName();
                    // 画像の保存
                    \Storage::disk('public')->putFileAs($dir, $upload_file, $file_name);

                    PlanImages::create([
                        'image_path' => $file_name,
                        'image_url' => 'storage/' . $dir . '/' . $file_name,
                        'plan_id' => $plan->id
                    ]);
                }

                // // アップロードされたファイルを変数に格納
                // $upload_file = $request->file('images');

                // // ディレクトリ名
                // $dir = 'images';

                // // アップロードされたファイル名を取得
                // $file_name = $upload_file->getClientOriginalName();
                // // 一意のファイル名を生成 (例: originalFileName_timestamp.ext)
                // // $file_name = pathinfo($upload_file->getClientOriginalName(), PATHINFO_FILENAME) . '_' . time() . '.' . $upload_file->getClientOriginalExtension();


                // // 取得したファイル名で保存
                // // storage/app/public/任意のディレクトリ名/
                // \Storage::disk('public')->putFileAs($dir, $upload_file, $file_name);


                // // // アップロード先S3フォルダ名
                // // $dir = 'reservesystem';

                // // // バケット内の指定フォルダへアップロード ※putFileはLaravel側でファイル名の一意のIDを自動的に生成してくれます。
                // // $s3_upload = Storage::disk('s3')->putFile('/' . $dir, $upload_file);

                // // // ※オプション（ファイルダウンロード、削除時に使用するS3でのファイル保存名、アップロード先のパスを取得します。）
                // // // アップロードファイルurlを取得
                // // $s3_url = Storage::disk('s3')->url($s3_upload);

                // // // s3_urlからS3でのファイル保存名取得
                // // $s3_upload_file_name = explode("/", $s3_url)[5];

                // // // アップロード先パスを取得 ※ファイルダウンロード、削除で使用します。
                // // $s3_path = $dir . '/' . $s3_upload_file_name;

                // PlanImages::create([
                //     'image_path' => $file_name,
                //     'image_url' => 'storage/' . $dir . '/' . $file_name,
                //     'plan_id' => $plan->id
                // ]);
            }
        });

        return  redirect()->back()->with('success', '宿泊プランを作成しました。');
    }

    // プラン情報を更新
    public static function updatePlan(Request $request, Plan $plan)
    {
        \DB::transaction(static function () use ($request, $plan) {
            $plan->update([
                'title' => $request['title'],
                'explain' => $request['explain'],
            ]);

            // 送信された部屋タイプの料金のみを取得
            $roomInputs = collect($request['price'])->filter(function ($value) {
                return !is_null($value) && $value !== '';
            });


            foreach ($request['room_master_id'] as $roomMasterId) {
                $currentMatchingRoomSlots = RoomSlot::where('room_master_id', $roomMasterId)
                    ->whereHas('planRooms', function ($query) use ($plan) {
                        $query->where('plan_id', $plan->id);
                    })->pluck('id')->toArray();

                $submittedRoomSlots = RoomSlot::where('room_master_id', $roomMasterId)
                    ->whereBetween('day', [$request['start_day'], $request['end_day']])->get();

                if ($submittedRoomSlots->isEmpty()) {
                    throw new \Exception('指定した日付の予約枠が存在しません。');
                }

                $submittedMatchingRoomSlots = $submittedRoomSlots->pluck('id')->toArray();

                // 削除分のRoomSlotsを取得
                $roomSlotsToDelete = array_diff($currentMatchingRoomSlots, $submittedMatchingRoomSlots);

                // PlanRoomの削除
                foreach ($roomSlotsToDelete as $roomSlotToDelete) {
                    PlanRoom::where(
                        ['plan_id' => $plan->id, 'room_slot_id' => $roomSlotToDelete]
                    )->delete();
                }

                // PlanRoomの更新または作成
                foreach ($submittedMatchingRoomSlots as $matchingRoomSlot) {
                    PlanRoom::updateOrCreate(
                        ['plan_id' => $plan->id, 'room_slot_id' => $matchingRoomSlot],
                        ['price' => $roomInputs[$roomMasterId]]
                    );
                }
            }

            // PlanImagesの更新または作成
            if ($request->hasFile('images')) {
                // アップロードされたファイルを変数に格納
                foreach ($request->file('images') as $upload_file) {
                    // ディレクトリ名
                    $dir = 'images';
                    // アップロードされたファイル名を取得
                    $file_name = $upload_file->getClientOriginalName();
                    // 画像の保存
                    \Storage::disk('public')->putFileAs($dir, $upload_file, $file_name);

                    PlanImages::create([
                        'image_path' => $file_name,
                        'image_url' => 'storage/' . $dir . '/' . $file_name,
                        'plan_id' => $plan->id
                    ]);
                }
            }
        });

        return  redirect()->back()->with('success', '宿泊プランを作成しました。');
    }

    // プランの料金情報を更新
    public static function updatePlanCharge(Request $request, PlanRoom $planRoom)
    {
        \DB::transaction(static function () use ($request, $planRoom) {
            $planRoom->update([
                'price' => $request['price'],
            ]);
        });
    }
}
