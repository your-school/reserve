@extends('layouts.admin-layout')


@section('content')
    <main>
        <section class="px-6 py-10 mx-auto tails-selected-element max-w-2xl">
            <h1 class="block text-4xl font-bold text-gray-800 text-black mb-10 text-center">予約内容詳細</h1>

            @if ($reservation->cancel_flag == 1)
                <div class="block text-xl font-bold text-red-500  mb-11 text-center border border-red-500 py-2">キャンセル済みの予約です
                </div>
            @endif


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
                <label for="first_name" class="block mb-2 text-lg font-medium text-black">合計料金</label>
                <div class="flex flex-col md:flex-row space-y-4 md:space-y-0 md:space-x-4">
                    <div class="flex flex-col font-bold">
                        {{ $reservation->total_price }}円
                    </div>
                </div>
            </div>

            {{-- 宿泊期間 --}}
            <div class="mb-8">
                <label for="number_of_people" class="block mb-2 text-lg font-medium text-black mb-4">宿泊期間</label>
                <div class="flex flex-col md:flex-row space-y-4 md:space-y-0 md:space-x-4">
                    <div class="flex flex-col font-bold">
                        {{ $reservation->start_day }}　〜　{{ $reservation->end_day }}
                    </div>
                </div>
            </div>

            <!-- 苗字 -->
            <div class="mb-8">
                <label for="first_name" class="block mb-2 text-lg font-medium text-black">苗字:</label>
                <div class="flex flex-col font-bold">
                    {{ $reservation->first_name }}
                </div>
            </div>

            <!-- 名前 -->
            <div class="mb-8">
                <label for="last_name" class="block mb-2 text-lg font-medium text-black">名前:</label>
                <div class="flex flex-col font-bold">
                    {{ $reservation->last_name }}
                </div>
            </div>

            <!-- 宿泊人数 -->
            <div class="mb-8">
                <label for="number_of_people" class="block mb-2 text-lg font-medium text-black">宿泊人数</label>
                <div class="flex flex-col font-bold">
                    {{ $reservation->number_of_people }}
                </div>
            </div>

            <!-- メールアドレス -->
            <div class="mb-8">
                <label for="email" class="block mb-2 text-lg font-medium text-black">メールアドレス</label>
                <div class="flex flex-col font-bold">
                    {{ $reservation->email }}
                </div>
            </div>

            <!-- 電話番号 -->
            <div class="mb-8">
                <label for="phone_number" class="block mb-2 text-lg font-medium text-black">電話番号</label>
                <div class="flex flex-col font-bold">
                    {{ $reservation->phone_number }}
                </div>
            </div>

            <!-- 郵便番号 -->
            <div class="mb-8">
                <label for="post_code" class="block mb-2 text-lg font-medium text-black">郵便番号</label>
                <div class="flex flex-col font-bold">
                    {{ $reservation->post_code }}
                </div>
            </div>

            <!-- 住所 -->
            <div class="mb-8">
                <label for="address" class="block mb-2 text-lg font-medium text-black">住所</label>
                <div class="flex flex-col font-bold">
                    {{ $reservation->address }}
                </div>
            </div>

            <!-- メッセージ -->
            <div class="mb-8">
                <label for="message" class="block mb-2 text-lg font-medium text-black">メッセージ</label>
                <div class="flex flex-col font-bold">
                    {{ $reservation->message }}
                </div>
            </div>

            <form id="inquiry-form" method="POST" action="{{ route('admin.reservation.update', $reservation) }}"
                enctype="multipart/form-data">
                @method('PUT')
                @csrf

                <!-- 管理者メモ -->
                <div class="mb-8">
                    <label for="admin_memo" class="block mb-2 text-lg font-medium text-black">管理者メモ</label>
                    <textarea id="admin_memo" name='admin_memo'
                        class="bg-gray-50 border border-gray-300 text-gray-900 text-lg rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                        placeholder="管理者側用のメモ">{{ $reservation->admin_memo }}</textarea>
                    @error('admin_memo')
                        <span class="text-red-500 text-sm">{{ $message }}</span>
                    @enderror
                </div>

                <div class="flex items-center justify-center mt-16">
                    <button type="submit"
                        class="font-semibold text-white bg-blue-500 hover:bg-blue-600 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-lg px-20 py-3 text-center dark:bg-blue-400 dark:hover:bg-blue-500 dark:focus:ring-blue-600 mb-4">変更する</button>
                </div>
            </form>
            @if ($reservation->cancel_flag == 0)
                <div class="flex items-center justify-center mb-16">
                    <form action="{{ route('admin.reservation.cancel', $reservation) }}" method="POST" class="mt-4">
                        @csrf
                        <button type="submit" onclick="return confirm('本当にキャンセルしますか？')"
                            class="font-semibold text-white bg-red-500 hover:bg-red-600 focus:ring-4 focus:outline-none focus:ring-red-300 font-medium rounded-lg text-lg px-20 py-3 text-center dark:bg-red-400 dark:hover:bg-red-500 dark:focus:ring-red-600">
                            予約キャンセル
                        </button>
                    </form>
                </div>
            @endif

        </section>
    </main>
@endsection
