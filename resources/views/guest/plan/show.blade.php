@extends('layouts.layout')

@section('content')
    <main>
        <div class="max-w-6xl px-5 py-5 md:py-10 mx-auto md:px-10 tails-selected-element">

            <section class="mx-1.5 md:mx-7 mb-5">
                <div class="py-4 px-5 text-2xl font-bold bg-red-100 mt-5 mb-16 md:mt-0">宿泊プラン詳細</div>
            </section>

            <section class="flex flex-wrap overflow-hidden md:px-0">

                <div id="planSection" class="w-full overflow-hidden w-full md:px-5">
                    <div class="mx-1.5">

                        <div class="my-10">
                            <div class="my-5 border rounded">
                                <div class="mx-1 my-1.5 p-2 bg-red-500 rounded font-bold text-white text-2xl">
                                    {{ $plan->title }}</div>
                                <div class="flex flex-wrap md:flex-nowrap">
                                    <div class="p-3 w-1/2">
                                        <div class="pt-1">
                                            <h2 class="pl-2 font-bold">プラン説明</h2>
                                            <div class="text-sm bg-white w-4/5 p-2.5">
                                                {{ $plan->explain }}</div>
                                        </div>
                                    </div>

                                    <div class="p-3 w-1/2">
                                        <div class="pt-1">
                                            <h2 class="pl-2 font-bold">住所</h2>
                                            <div class="text-sm bg-white w-4/5 p-2.5 border-b border-gray-300">
                                                テスト</div>
                                        </div>
                                        <div class="pt-2">
                                            <h2 class="pl-2 font-bold">公式サイト</h2>
                                            <div class="text-sm bg-white w-4/5 p-2.5 border-b border-gray-300 underline overflow-hidden"
                                                target="_blank" style="word-wrap: break-word;">
                                                <a href="{{ url('/') }}" target="_blank">あ</a>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="m-3 container border border-gray-300 w-2/5">
                                    <div class="flex">
                                        <div
                                            class="text-sm font-bold bg-red-100 w-1/3 p-2.5 border-r border-b border-gray-300">
                                            期間</div>
                                        <div class="text-sm bg-white w-2/3 p-2.5 border-b border-gray-300">
                                            {{ $plan->roomSlots->min('day') }} 〜
                                            {{ $plan->roomSlots->max('day') }}</div>
                                    </div>
                                    <div class="flex">
                                        <div class="text-sm font-bold bg-red-100 w-1/3 p-2.5 border-r border-gray-300">
                                            お支払い
                                        </div>
                                        <div class="text-sm bg-white w-2/3 p-2.5">現金のみ</div>
                                    </div>
                                </div>
                                <div class="p-3 w-full w-xl-1/2">
                                    <h2 class="pl-2 my-3 font-bold">お部屋の種類</h2>
                                    @foreach ($plan->groupedRooms as $rooms)
                                        <div
                                            class="flex flex-wrap md:flex-nowrap border-b border-gray-300 py-2 mr-8 mr-xl-0 ml-3">
                                            <div class="text-sm bg-white p-3">
                                                部屋：<span class="font-bold">
                                                    <a href="{{ url('/') }}" class="underline"
                                                        target="_blank">{{ $rooms->first()->roomMaster->name }}</span></a>
                                            </div>
                                            {{-- <div class="text-sm bg-white p-3">一人あたりの料金：<span class="font-bold">￥
                                                        {{ $room}}</span></div> --}}
                                            <div class="text-sm bg-white p-3">最大人数：
                                                {{ $rooms->first()->roomMaster->capacity }}人</div>
                                            {{-- <button type="button"
                                                onclick="openModal({{ $plan }}, {{ $rooms }} )"
                                                class="mx-10 my-3 text-gray-600 bg-white hover:bg-gray-200 focus:ring-4 focus:outline-none border border-gray-600 focus:ring-gray-300 font-medium rounded-lg text-lg px-7 py-2 text-center">
                                                カレンダーから予約
                                            </button> --}}
                                            <a href="{{ route('plan.showCalender', ['plan' => $plan, 'roomMasterId' => $rooms->first()->room_master_id]) }}"
                                                class="mx-10 my-3 text-gray-600 bg-white hover:bg-gray-200 focus:ring-4 focus:outline-none border border-gray-600 focus:ring-gray-300 font-medium rounded-lg text-lg px-7 py-2 text-center">
                                                カレンダーから予約
                                            </a>
                                        </div>
                                        <div id="calendarModal"
                                            class="fixed top-0 left-0 w-full h-full bg-gray-800 bg-opacity-60 flex justify-center items-center hidden">
                                            <div class="bg-white p-5 rounded shadow-lg w-3/4 h-3/4">
                                                <div id="calendar"></div>
                                            </div>
                                        </div>
                                        {{-- <script>
                                            document.addEventListener('DOMContentLoaded', function() {
                                                var calendarEl = document.getElementById('calendar');

                                                var allReservationDates = {};

                                                @foreach ($plan->groupedRooms as $rooms)
                                                    @foreach ($rooms as $room)
                                                        allReservationDates[{{ $room->id }}] = {};
                                                        var countByStock = @json($room['stock']);
                                                        var idsByDate = @json($room['day']);
                                                        var count = countByStock;
                                                        var titleText = count > 3 ? '◯' : (count > 0 ? '△：残り' + count + '部屋' : '×');

                                                        allReservationDates[{{ $plan->id }}][{{ $room->id }}] = {
                                                            title: titleText,
                                                            start: idsByDate,
                                                            color: count > 0 ? '#00FF00' : '#FF0000',
                                                            textColor: '#000000',
                                                            allDay: true,
                                                        };
                                                    @endforeach
                                                @endforeach

                                                // FullCalendarに渡すためのイベントデータ配列を生成
                                                var events = [];
                                                for (var planId in allReservationDates) {
                                                    for (var roomId in allReservationDates[planId]) {
                                                        events.push(allReservationDates[planId][roomId]);
                                                    }
                                                }

                                                var calendar = new FullCalendar.Calendar(calendarEl, {
                                                    initialView: 'dayGridMonth',
                                                    locale: 'ja',
                                                    timeZone: 'Asia/Tokyo',
                                                    height: 'auto',
                                                    firstDay: 0,
                                                    headerToolbar: {
                                                        left: "dayGridMonth",
                                                        center: "title",
                                                        right: "today prev,next"
                                                    },
                                                    buttonText: {
                                                        today: '今月',
                                                        month: '月',
                                                        list: 'リスト'
                                                    },
                                                    noEventsContent: 'スケジュールはありません',
                                                    events: events // ここでイベントデータを渡す
                                                });

                                                calendar.render();
                                            });
                                        </script> --}}
                                    @endforeach
                                </div>
                            </div>
                        </div>
                    </div>
                    {{-- <div class="my-2 mx-1.5">
                        @foreach ($plan->roomSlots->pluck('day')->unique()->sort()->values() as $day)
                            <div class="mt-2 p-4 border border-gray-300 rounded">
                                <div class="truncate overflow-hidden text-gray-600 text-sm">
                                    {{ $day }}<span
                                        class="text-gray-400 inline-flex items-center inline text-sm ml-4">
                                        <form action="{{ route('room.create') }}" method="get">
                                            <button type="submit"
                                                class="text-gray-600 bg-white hover:bg-gray-200 focus:ring-4 focus:outline-none border border-gray-600 focus:ring-gray-300 font-medium rounded-lg text-lg px-7 py-2 text-center">予約する</button>
                                        </form>
                                </div>

                                <h2 class="text-red-500 tracking-widest text-sm mt-2.5">
                                テスト <span class="text-gray-400 inline-flex items-center inline text-sm ml-4">
                                    更新日:テスト</span></h2>
                            </div>
                        @endforeach
                    </div> --}}
                </div>
            </section>
        </div>
    </main>
@endsection
