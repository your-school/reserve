@extends('layouts.layout')

@section('content')
    <main>

        @php
            $roomTypes = [
                '1' => 'シングルルーム',
                '2' => 'ツインルーム',
                '3' => 'デラックスルーム',
                '4' => 'キングルーム',
            ];
        @endphp


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
                                    {{ $stayingPlan->title }}</div>
                                <div class="flex flex-wrap md:flex-nowrap">
                                    <div class="p-3 w-1/2">
                                        <div class="pt-1">
                                            <h2 class="pl-2 font-bold">プラン説明</h2>
                                            <div class="text-sm bg-white w-4/5 p-2.5">
                                                {{ $stayingPlan->explain }}</div>
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
                                            {{ $stayingPlan->reservationSlots->min('day') }} 〜
                                            {{ $stayingPlan->reservationSlots->max('day') }}</div>
                                    </div>
                                    <div class="flex">
                                        <div class="text-sm font-bold bg-red-100 w-1/3 p-2.5 border-r border-gray-300">
                                            お支払い
                                        </div>
                                        <div class="text-sm bg-white w-2/3 p-2.5">現金のみ</div>
                                    </div>
                                </div>

                                <div class="p-3">
                                    <h2 class="pl-2 my-3 font-bold">お部屋を選択</h2>
                                    <div class="flex flex-wrap md:flex-nowrap border-y border-gray-300">

                                        <div class="text-sm bg-white p-3">
                                            部屋：
                                            <a href="{{ url('/') }}" class="underline"
                                                target="_blank">{{ $roomTypes[$stayingPlan->reservationSlots->first()->roomMaster->room_type] }}</a>
                                        </div>
                                        <div class="text-sm bg-white p-3">一人あたりの料金：￥
                                            {{ $stayingPlan->reservationSlotStayingPlans->first()->price }}</div>
                                    </div>
                                    <div class="pt-2 mb-3">
                                        <div class="text-sm bg-white p-3 border-b border-gray-300 underline overflow-hidden"
                                            target="_blank" style="word-wrap: break-word;">
                                            <a href="{{ url('/') }}" target="_blank">あ</a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="my-2 mx-1.5">
                        @foreach ($stayingPlan->reservationSlots->pluck('day')->unique()->sort()->values() as $day)
                            <div class="mt-2 p-4 border border-gray-300 rounded">
                                <div class="truncate overflow-hidden text-gray-600 text-sm">
                                    {{ $day }}<span
                                        class="text-gray-400 inline-flex items-center inline text-sm ml-4">
                                        <form action="{{ route('reservation.create') }}" method="get">
                                            <button type="submit"
                                                class="text-gray-600 bg-white hover:bg-gray-200 focus:ring-4 focus:outline-none border border-gray-600 focus:ring-gray-300 font-medium rounded-lg text-lg px-7 py-2 text-center">予約する</button>
                                        </form>
                                </div>

                                {{-- <h2 class="text-red-500 tracking-widest text-sm mt-2.5">
                                テスト <span class="text-gray-400 inline-flex items-center inline text-sm ml-4">
                                    更新日:テスト</span></h2> --}}
                            </div>
                        @endforeach
                    </div>
                </div>

            </section>
        </div>
        <script>
            var allReservationDates = {};

            @foreach ($stayingPlans as $plan)
                var countByDate = @json($plan->reservationSlots->groupBy('day')->map->count());
                console.log(countByDate);
                var idsByDate = @json($plan->reservationSlotStayingPlans->whereNull('reservation_id')->groupBy('reservationSlot.day')->map->first()->pluck('id'));
                console.log(idsByDate);

                allReservationDates[{{ $plan->id }}] = Object.keys(countByDate).map(function(date, index) {
                    var titleText = countByDate[date] > 2 ? '◯' : '残り：' + countByDate[date] + '部屋';
                    var eventId = idsByDate[index]; // 同じインデックスのidsByDateの値を取得

                    return {
                        title: titleText,
                        start: date,
                        id: eventId, // idsByDateからIDを取得
                    };
                });

                function handleDateSelection(targetDate) {
                    var selectedEvent = allReservationDates[planId].find(function(event) {
                        return event.start === targetDate;
                    });

                    if (selectedEvent) {
                        var selectedReservationSlotId = selectedEvent.id;
                        var url = "{{ url('reservation/create') }}/" + selectedReservationSlotId;
                        var userConfirmed = confirm("選択した日付での予約を開始しますか？");

                        if (userConfirmed) {
                            window.location.href = url;
                        }
                    }
                }

                var calendarEl = document.getElementById('calendar');
                var calendarEvents = allReservationDates[planId];
                var calendar = new FullCalendar.Calendar(calendarEl, {
                    initialView: 'dayGridMonth',
                    locale: 'ja',
                    timeZone: 'Asia/Tokyo',
                    height: 'auto',
                    firstDay: 0,
                    headerToolbar: {
                        left: "dayGridMonth",
                        center: "title",
                        right: "today prev,next closeButton"
                    },
                    buttonText: {
                        today: '今月',
                        month: '月',
                        list: 'リスト'
                    },
                    customButtons: {
                        closeButton: {
                            text: '閉じる',
                            click: function() {
                                closeModal();
                            }
                        }
                    },
                    events: calendarEvents,
                    selectable: true,
                    select: function(info) {
                        var targetDate = info.startStr;
                        handleDateSelection(targetDate);
                    },
                    eventClick: function(info) {
                        var targetDate = info.event.startStr;
                        handleDateSelection(targetDate);
                    },
                });

                calendar.render();
        </script>
    </main>
@endsection
