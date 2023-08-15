<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\StayingPlanRequest;
use Carbon\Carbon;
use App\Models\StayingPlan;
use App\Models\PlanImages;
use App\Models\ReservationSlotStayingPlan;
use App\Models\ReservationSlot;
use Storage;



class StayingPlanController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $stayingPlans = StayingPlan::with(['reservationSlots'])->get();
        
        return view('admin.staying-plan', compact('stayingPlans'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        
        return view('admin.staying-plan-create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StayingPlanRequest $request)
    {
        // 1. StayingPlanテーブルにデータの挿入
        $stayingPlan = StayingPlan::create([
            'title' => $request->title,
            'explain' => $request->explain,
        ]);

        // 3. ReservationSlotStayingPlanテーブルに関連するデータの挿入
        $startDay = Carbon::parse($request->start_day);
        $endDay = Carbon::parse($request->end_day);
        
        $reservationSlots = ReservationSlot::where('room_master_id', $request->room_master_id)
                                   ->whereBetween('day', [$startDay, $endDay])
                                   ->get();

        foreach ($reservationSlots as $slot) {
            ReservationSlotStayingPlan::create([
                'staying_plan_id' => $stayingPlan->id,
                'reservation_slot_id' => $slot->id,
                'price' => $request->price,
            ]);
        }

        // 2. PlanImagesテーブルに画像データの挿入
        if ($request->hasFile('image')) {
                // アップロードされたファイルを変数に格納
            $upload_file = $request->file('image');
        
            // アップロード先S3フォルダ名 
            $dir = 'reservesystem';
    
            // バケット内の指定フォルダへアップロード ※putFileはLaravel側でファイル名の一意のIDを自動的に生成してくれます。
            $s3_upload = Storage::disk('s3')->putFile('/'.$dir, $upload_file);
    
            // ※オプション（ファイルダウンロード、削除時に使用するS3でのファイル保存名、アップロード先のパスを取得します。）
            // アップロードファイルurlを取得
            $s3_url = Storage::disk('s3')->url($s3_upload);

            // s3_urlからS3でのファイル保存名取得
            $s3_upload_file_name = explode("/", $s3_url)[5];
    
            // アップロード先パスを取得 ※ファイルダウンロード、削除で使用します。
            $s3_path = $dir.'/'.$s3_upload_file_name;
            
            PlanImages::create([
                'image_path' => $upload_file,
                'staying_plan_id' => $stayingPlan->id
            ]);
        }

        return redirect()->route('staying_plan.index')->with('success', '宿泊プランを作成しました。');
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
        $stayingPlan = StayingPlan::find($id);

        if (!$stayingPlan) {
            // エラーメッセージやリダイレクトをここで行う
            return redirect()->back()->with('error', '宿泊プランが見つかりませんでした。');
        }

        // 関連するReservationSlotStayingPlanのデータを削除
        $stayingPlan->reservationSlots()->detach();

        // 関連するPlanImagesのデータを削除
        foreach ($stayingPlan->planImages as $image) {
            // 必要に応じて物理的な画像ファイルも削除することができます
            $image->delete();
        }

        // StayingPlanを削除
        $stayingPlan->delete();

        // 削除が完了したら、一覧ページなどにリダイレクトする
        return redirect()->route('staying_plan.index')->with('success', '宿泊プランを削除しました。');
    }

}
