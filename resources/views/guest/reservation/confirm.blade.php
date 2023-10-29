@extends('layouts.layout')


@section('content')
    <main>
        <section class="px-6 py-10 mx-auto tails-selected-element max-w-2xl">
            <form id="inquiry-form" method="POST" action="{{ route('reservation.store') }}" enctype="multipart/form-data">
                @method('POST')
                @csrf
                <input type='hidden' name='plan_room_id' value="{{ $planRoom['id'] }}">

                <h1 class="block text-4xl font-bold text-gray-800 text-black mb-11 text-center">予約内容の確認</h1>


                <div class="mb-8">
                    <label for="first_name" class="block mb-2 text-lg font-medium text-black">プラン名</label>
                    <div class="flex flex-col md:flex-row space-y-4 md:space-y-0 md:space-x-4">
                        <div class="flex flex-col font-bold">
                            {{ $planRoom->plan->title }}
                        </div>
                    </div>
                </div>

                <div class="mb-8">
                    <label for="first_name" class="block mb-2 text-lg font-medium text-black">部屋名</label>
                    <div class="flex flex-col md:flex-row space-y-4 md:space-y-0 md:space-x-4">
                        <div class="flex flex-col font-bold">
                            {{ $planRoom->roomSlot->roomMaster->name }}
                        </div>
                    </div>
                </div>

                <div class="mb-8">
                    <label for="first_name" class="block mb-2 text-lg font-medium text-black">料金</label>
                    <div class="flex flex-col md:flex-row space-y-4 md:space-y-0 md:space-x-4">
                        <div class="flex flex-col font-bold">
                            {{ $planRoom->price }}円
                        </div>
                    </div>
                </div>

                {{-- 宿泊期間 --}}
                <div class="mb-8">
                    <label for="number_of_people" class="block mb-2 text-lg font-medium text-black mb-4">宿泊期間</label>
                    <div class="flex flex-col md:flex-row space-y-4 md:space-y-0 md:space-x-4">
                        <div class="flex flex-col">
                            {{ $request->start_day }}　〜　{{ $request->end_day }}
                        </div>
                    </div>
                </div>

                <!-- 苗字 -->
                <div class="mb-8">
                    <label for="first_name" class="block mb-2 text-lg font-medium text-black">苗字:</label>
                    {{ $request->first_name }}
                </div>

                <!-- 名前 -->
                <div class="mb-8">
                    <label for="last_name" class="block mb-2 text-lg font-medium text-black">名前:</label>
                    {{ $request->last_name }}
                </div>

                <!-- 宿泊人数 -->
                <div class="mb-8">
                    <label for="number_of_people" class="block mb-2 text-lg font-medium text-black">宿泊人数</label>
                    {{ $request->number_of_people }}
                </div>

                <!-- メールアドレス -->
                <div class="mb-8">
                    <label for="email" class="block mb-2 text-lg font-medium text-black">メールアドレス</label>
                    {{ $request->email }}
                </div>

                <!-- 電話番号 -->
                <div class="mb-8">
                    <label for="phone_number" class="block mb-2 text-lg font-medium text-black">電話番号</label>
                    {{ $request->phone_number }}
                </div>

                <!-- 郵便番号 -->
                <div class="mb-8">
                    <label for="post_code" class="block mb-2 text-lg font-medium text-black">郵便番号</label>
                    {{ $request->post_code }}
                </div>

                <!-- 住所 -->
                <div class="mb-8">
                    <label for="address" class="block mb-2 text-lg font-medium text-black">住所</label>
                    {{ $request->address }}
                </div>

                <!-- メッセージ -->
                <div class="mb-8">
                    <label for="message" class="block mb-2 text-lg font-medium text-black">メッセージ</label>
                    {{ $request->message }}
                </div>

                <div class="block justify-center my-16">
                    <button type="submit"
                        class="font-semibold text-white bg-red-500 hover:bg-red-600 focus:ring-4 focus:outline-none focus:ring-red-300 font-medium rounded-lg text-lg px-20 py-3 text-center dark:bg-red-400 dark:hover:bg-red-500 dark:focus:ring-red-600">予約する</button>
                    <a href="{{ route('reservation.create', $planRoom['id']) }}"
                        class="font-semibold text-white bg-gray-400 hover:bg-gray-600 focus:ring-4 focus:outline-none focus:ring-gray-300 font-medium rounded-lg text-lg px-20 py-3 text-center dark:bg-gray-400 dark:hover:bg-gray-500 dark:focus:ring-gray-600">入力画面へ戻る</a>
                </div>

            </form>
        </section>
    </main>
@endsection
