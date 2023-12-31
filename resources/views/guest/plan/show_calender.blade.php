@extends('layouts.layout')

@section('content')
    <main>
        <div class="max-w-6xl px-5 py-5 md:py-10 mx-auto md:px-10 tails-selected-element">

            <section class="mx-1.5 md:mx-7 mb-5">
                <div class="py-4 px-5 text-2xl font-bold bg-red-100 mt-5 mb-16 md:mt-0">カレンダーから日にちを探す</div>
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
                                    <div id="calendar"></div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </section>
        </div>
    </main>
    @php
        $events = $roomSlots
            ->map(function ($roomSlot) use ($plan) {
                if ($roomSlot->stock > 3) {
                    $title = '⚪︎ ' . number_format($roomSlot->price) . '円';
                } elseif ($roomSlot->stock > 0) {
                    $title = '△残り' . $roomSlot->stock . '部屋 ' . number_format($roomSlot->price) . '円';
                } else {
                    $title = '×';
                }

                return [
                    'title' => $title,
                    'start' => $roomSlot->day,
                    'url' => route('reservation.create', $roomSlot->planRoomId),
                ];
            })
            ->toArray();
    @endphp
    <script>
        var events = @json($events);
        document.addEventListener('DOMContentLoaded', function() {
            var calendarEl = document.getElementById('calendar');

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
                events: events,
                eventClick: function(info) {
                    window.location.href = info.event.url; // イベントのURLへ遷移
                },
                dayCellDidMount: function(cellInfo) {
                    var today = new Date();
                    today.setHours(0, 0, 0, 0); // Set to start of day

                    if (cellInfo.date < today) {
                        cellInfo.el.style.backgroundColor = '#d3d3d3'; // Gray for past dates
                    } else if (cellInfo.date.getUTCDay() === 6) {
                        cellInfo.el.style.backgroundColor = '#e0ffff'; // Blue for Saturday
                    } else if (cellInfo.date.getUTCDay() === 0) {
                        cellInfo.el.style.backgroundColor = '#ffc0cb'; // Red for Sunday
                    }
                }
            });

            calendar.render();
        });
    </script>
@endsection
