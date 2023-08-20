@extends('layouts.layout')


@section('content')
    <main>
        <section class="px-6 py-10 mx-auto tails-selected-element max-w-2xl">
            <form id="inquiry-form" method="POST" action="{{ route('reservation.store') }}" enctype="multipart/form-data">
                @method('POST')
                @csrf
                <input type='hidden' name='reservation_slot_staying_plan_id'
                    value="{{ $reservation_slot_staying_plan['id'] }}">
                <input type='hidden' name='start_day' value="{{ $reservation_slot_staying_plan->reservationSlot->day }}">

                <h1 class="block text-4xl font-bold text-gray-800 text-black mb-11 text-center">予約フォーム </h1>


                <div class="mb-8">
                    <label for="first_name" class="block mb-2 text-lg font-medium text-black">プラン名</label>
                    <div class="flex flex-col md:flex-row space-y-4 md:space-y-0 md:space-x-4">
                        <div class="flex flex-col">
                            {{ $reservation_slot_staying_plan->stayingPlan->title }}
                        </div>
                    </div>
                </div>

                <div class="mb-8">
                    <label for="number_of_people" class="block mb-2 text-lg font-medium text-black mb-4">宿泊日時</label>
                    <div class="flex flex-col md:flex-row space-y-4 md:space-y-0 md:space-x-4">
                        <div class="flex flex-col">
                            {{ $reservation_slot_staying_plan->reservationSlot->day }}
                        </div>
                        {{-- <div class="flex flex-col">
                            <input type="date" id="start_day" name="start_day" class="p-2 border rounded-md">
                        </div>
                        <div class="flex flex-col">
                            <div class="p-2">〜</div>
                        </div>
                        <div class="flex flex-col">
                            <input type="date" id="end_day" name="end_day" class="p-2 border rounded-md">
                        </div> --}}
                    </div>
                </div>

                <!-- 苗字 -->
                <div class="mb-8">
                    <label for="first_name" class="block mb-2 text-lg font-medium text-black">苗字:</label>
                    <input id="autocomplete" type="text" name='first_name'
                        class="bg-gray-50 border border-gray-300 text-gray-900 text-lg rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                        placeholder="苗字をご入力ください">
                    @error('first_name')
                        <span class="text-red-500 text-sm">{{ $message }}</span>
                    @enderror
                </div>

                <!-- 名前 -->
                <div class="mb-8">
                    <label for="last_name" class="block mb-2 text-lg font-medium text-black">名前:</label>
                    <input id="autocomplete" type="text" name='last_name'
                        class="bg-gray-50 border border-gray-300 text-gray-900 text-lg rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                        placeholder="お名前をご入力ください">
                    @error('last_name')
                        <span class="text-red-500 text-sm">{{ $message }}</span>
                    @enderror
                </div>

                <!-- 宿泊人数 -->
                <div class="mb-8">
                    <label for="number_of_people" class="block mb-2 text-lg font-medium text-black">宿泊人数</label>
                    <input id="autocomplete" type="number" min="1" max="30" name='number_of_people'
                        class="bg-gray-50 border border-gray-300 text-gray-900 text-lg rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500">
                    @error('number_of_people')
                        <span class="text-red-500 text-sm">{{ $message }}</span>
                    @enderror
                </div>

                <!-- メールアドレス -->
                <div class="mb-8">
                    <label for="email" class="block mb-2 text-lg font-medium text-black">メールアドレス</label>
                    <input id="autocomplete" type="email" name='email'
                        class="bg-gray-50 border border-gray-300 text-gray-900 text-lg rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                        placeholder="メールアドレスをご入力ください">
                    @error('email')
                        <span class="text-red-500 text-sm">{{ $message }}</span>
                    @enderror
                </div>

                <!-- 電話番号 -->
                <div class="mb-8">
                    <label for="phone_number" class="block mb-2 text-lg font-medium text-black">電話番号</label>
                    <input id="phone" type="tel" name='phone_number'
                        class="bg-gray-50 border border-gray-300 text-gray-900 text-lg rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                        placeholder="電話番号をご入力ください">
                    @error('phone_number')
                        <span class="text-red-500 text-sm">{{ $message }}</span>
                    @enderror
                </div>

                <!-- 郵便番号 -->
                <div class="mb-8">
                    <label for="post_code" class="block mb-2 text-lg font-medium text-black">郵便番号</label>
                    <input id="zipcode" type="text" name='post_code'
                        class="bg-gray-50 border border-gray-300 text-gray-900 text-lg rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                        placeholder="郵便番号をご入力ください">
                    @error('post_code')
                        <span class="text-red-500 text-sm">{{ $message }}</span>
                    @enderror
                </div>

                <!-- 住所 -->
                <div class="mb-8">
                    <label for="address" class="block mb-2 text-lg font-medium text-black">住所</label>
                    <input id="address" type="text" name='address'
                        class="bg-gray-50 border border-gray-300 text-gray-900 text-lg rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                        placeholder="住所をご入力ください">
                    @error('address')
                        <span class="text-red-500 text-sm">{{ $message }}</span>
                    @enderror
                </div>

                <!-- メッセージ -->
                <div class="mb-8">
                    <label for="message" class="block mb-2 text-lg font-medium text-black">メッセージ</label>
                    <textarea id="message" name='message'
                        class="bg-gray-50 border border-gray-300 text-gray-900 text-lg rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                        placeholder="気になる点などあればご記入ください"></textarea>
                    @error('message')
                        <span class="text-red-500 text-sm">{{ $message }}</span>
                    @enderror
                </div>

                <div class="flex justify-center my-16">
                    <button type="submit"
                        class="text-white bg-red-500 hover:bg-red-600 focus:ring-4 focus:outline-none focus:ring-red-300 font-medium rounded-lg text-lg px-20 py-3 text-center dark:bg-red-400 dark:hover:bg-red-500 dark:focus:ring-red-600">お問合せを送る</button>
                </div>

            </form>
        </section>
    </main>
    <script>
        function autoFillAddress() {
            let zipcode = document.getElementById('zipcode').value;

            // ここでは郵便番号から住所を取得する例としてダミーのデータを用います。
            // 実際にはAPIやデータベースから正確な住所を取得する必要があります。
            let addressData = {
                "100-0001": "東京都千代田区皇居外苑",
                // 他の郵便番号データ
            };

            let address = addressData[zipcode];
            if (address) {
                document.getElementById('address').value = address;
            } else {
                // 郵便番号がデータにない場合は何もしないか、エラーメッセージを表示します。
            }
        }
    </script>
@endsection
