@extends('layouts.layout')


@section('content')
    <main>
        <section class="px-6 py-10 mx-auto tails-selected-element max-w-2xl">
            <form id="inquiry-form" method="POST" action="{{ route('reservation.store') }}" enctype="multipart/form-data">
                @method('POST')
                @csrf
                <input type='hidden' name='reservation_slot_staying_plan_id'
                    value="{{ $reservation_slot_staying_plan['id'] }}">
                <input type='hidden' name='room_master_id' id="room_master_id"
                    value="{{ $reservation_slot_staying_plan->reservationSlot->room_master_id }}">
                <input type='hidden' name='staying_plan_id' id="staying_plan_id"
                    value="{{ $reservation_slot_staying_plan->stayingPlan->id }}">

                <h1 class="block text-4xl font-bold text-gray-800 text-black mb-11 text-center">予約フォーム </h1>


                <div class="mb-8">
                    <label for="first_name" class="block mb-2 text-lg font-medium text-black">プラン名</label>
                    <div class="flex flex-col md:flex-row space-y-4 md:space-y-0 md:space-x-4">
                        <div class="flex flex-col font-bold">
                            {{ $reservation_slot_staying_plan->stayingPlan->title }}
                        </div>
                    </div>
                </div>

                <div class="mb-8">
                    <label for="first_name" class="block mb-2 text-lg font-medium text-black">部屋名</label>
                    <div class="flex flex-col md:flex-row space-y-4 md:space-y-0 md:space-x-4">
                        <div class="flex flex-col font-bold">
                            {{ $reservation_slot_staying_plan->reservationSlot->roomMaster->room_type }}
                        </div>
                    </div>
                </div>

                <div class="mb-8">
                    <label for="first_name" class="block mb-2 text-lg font-medium text-black">料金</label>
                    <div class="flex flex-col md:flex-row space-y-4 md:space-y-0 md:space-x-4">
                        <div class="flex flex-col font-bold">
                            {{ $reservation_slot_staying_plan->price }}円
                        </div>
                    </div>
                </div>

                {{-- 宿泊期間 --}}
                <div class="mb-8">
                    <label for="number_of_people" class="block mb-2 text-lg font-medium text-black mb-4">宿泊期間</label>
                    <div class="flex flex-col md:flex-row space-y-4 md:space-y-0 md:space-x-4">
                        <div class="flex flex-col">
                            <input type="date" id="start_day" name="start_day" class="p-2 border rounded-md"
                                value="{{ $reservation_slot_staying_plan->reservationSlot->day }}" readonly>
                        </div>
                        <div class="flex flex-col">
                            <div class="p-2">〜</div>
                        </div>
                        <div class="flex flex-col">
                            <input type="date" id="end_day" name="end_day" class="p-2 border rounded-md"
                                onchange="checkAvailability()">
                        </div>
                    </div>
                    <div id="message" class="font-semibold text-red-500  font-medium rounded-lg text-lg py-5">
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
                    <select id="autocomplete" type="number" min="1" max="30" name='number_of_people'
                        class="bg-gray-50 border border-gray-300 text-gray-900 text-lg rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500">
                        @for ($i = 1; $i <= $reservation_slot_staying_plan->reservationSlot->roomMaster->capacity; $i++)
                            <option value="{{ $i }}">{{ $i }}名</option>
                        @endfor
                    </select>
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
                        placeholder="例)00011112222">
                    @error('phone_number')
                        <span class="text-red-500 text-sm">{{ $message }}</span>
                    @enderror
                </div>

                {{-- <div class="flex justify-center">
                    <button type="button" id="search"
                        class='hover:text-gray-100
                        flex justify-center max-w-sm w-full bg-gradient-to-r from-orange-400 via-red-500 to-red-600 hover:from-orange-600 hover:via-red-600 hover:to-red-600 focus:outline-none text-white text-2xl uppercase font-bold shadow-md rounded-lg mx-auto p-3'>
                        <div class="col-span-2">住所検索</div>
                    </button>
                </div> --}}

                <!-- 郵便番号 -->
                <div class="mb-8">
                    <label for="post_code" class="block mb-2 text-lg font-medium text-black">郵便番号（ハイフンは抜いてください）</label>
                    <input id="zipcode_input" type="text" name='zipcode' value=""
                        class="bg-gray-50 border border-gray-300 text-gray-900 text-lg rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                        placeholder="例)0001111">
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
                        class="font-semibold text-white bg-red-500 hover:bg-red-600 focus:ring-4 focus:outline-none focus:ring-red-300 font-medium rounded-lg text-lg px-20 py-3 text-center dark:bg-red-400 dark:hover:bg-red-500 dark:focus:ring-red-600">予約する</button>
                </div>

            </form>
        </section>
    </main>

    {{-- <script src="https://cdn.jsdelivr.net/npm/fetch-jsonp@1.1.3/build/fetch-jsonp.min.js"></script> --}}
    {{-- <script src="{{ asset('path/to/your/javascript/file.js') }}"></script> --}}
    <script>
        function checkAvailability() {
            const startDay = document.getElementById('start_day').value;
            const endDay = document.getElementById('end_day').value;
            const roomMasterId = document.getElementById('room_master_id').value;
            const stayingPlanId = document.getElementById('staying_plan_id').value;

            fetch(`/api/check-stock/${startDay}/${endDay}/${roomMasterId}/${stayingPlanId}`)
                .then(response => response.json())
                .then(data => {
                    const messageDiv = document.getElementById('message');
                    console.log(messageDiv)

                    messageDiv.textContent = data.message;
                })
                .catch(error => {
                    console.error('Error:', error);
                });
        }


        document.getElementById('zipcode_input').addEventListener('change', function() {
            var zipCode = this.value;

            fetch(`/api/address/${zipCode}`)
                .then(response => response.json())
                .then(data => {
                    if (data.address) {
                        document.getElementById('address').value = data.address;
                    }
                })
                .catch(error => {
                    console.error('Error fetching address:', error);
                });
        });
    </script>
@endsection
