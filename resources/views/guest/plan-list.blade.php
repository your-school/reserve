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


        <main class="max-w-6xl px-5 py-5 md:py-10 mx-auto md:px-10 tails-selected-element">

            <section class="mx-1.5 md:mx-7 mb-5">

                <div class="w-full mb-12">
                    <div class="p-3 border border-gray-300 rounded my-5  bg-gray-100">
                        <div class="flex items-center pb-2 border-b border-gray-300 mb-5">
                            {{-- <img src="{{ asset('svg/human_icon.svg') }}" alt="customIcon" class="ml-0.5 w-4 h-4"> --}}
                            <span class="ml-2 text-gray-900 text-lg font-bold">詳細検索</span>
                        </div>
                        <form action="{{ route('plan.search') }}" method="GET">
                            <div class="container mx-auto my-8">
                                <h1 class="text-lg font-bold mb-2 ml-2">日付</h1>
                                <div class="flex flex-col md:flex-row space-y-4 md:space-y-0 md:space-x-4">
                                    <div class="flex flex-col">
                                        <input type="date" id="start_day" name="start_day" class="p-2 border rounded-md">
                                    </div>
                                    <div class="flex flex-col p-2">〜
                                    </div>
                                    <div class="flex flex-col">
                                        <input type="date" id="end_day" name="end_day" class="p-2 border rounded-md">
                                    </div>
                                </div>
                            </div>
                            <div class="flex justify-center my-8">
                                <button type="submit"
                                    class="text-white bg-gray-400 hover:bg-gray-500 focus:ring-4 focus:outline-none focus:ring-gray-300 font-medium rounded-lg text-lg px-10 py-3 text-center">検索</button>
                            </div>
                        </form>
                    </div>

                </div>

                <div class="py-4 px-5 text-2xl font-bold bg-red-100 mb-16 md:mt-0">宿泊プラン一覧</div>

                <div class="flex">
                    <button id="planButton"
                        class="w-1/3 h-12 text-white bg-red-500 border border-gray-200 shadow-inner hover:bg-white hover:text-red-500 focus:outline-none text-md font-semibold rounded">
                        プランで探す
                    </button>
                    <button id="roomButton"
                        class="w-1/3 h-12 text-white bg-red-500 border border-gray-200 shadow-inner hover:bg-white hover:text-red-500 focus:outline-none text-md font-semibold rounded">
                        お部屋で探す
                    </button>

                    <button id="calendarButton"
                        class="w-1/3 h-12 text-white bg-red-500 border border-gray-200 shadow-inner hover:bg-white hover:text-red-500 focus:outline-none text-md font-semibold rounded">
                        カレンダーから探す
                    </button>
                </div>
            </section>

            <section class="flex flex-wrap overflow-hidden md:px-0">

                <div id="planSection" class="w-full overflow-hidden w-full md:px-5">
                    <div class="mx-1.5">

                        @foreach ($stayingPlans as $plan)
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
                                                {{ $plan->reservationSlots->min('day') }} 〜
                                                {{ $plan->reservationSlots->max('day') }}</div>
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
                                                    target="_blank">{{ $roomTypes[$plan->reservationSlots->first()->roomMaster->room_type] }}</a>
                                            </div>
                                            <div class="text-sm bg-white p-3">一人あたりの料金：￥
                                                {{ $plan->reservationSlotStayingPlans->first()->price }}</div>
                                            <div class="text-sm bg-white py-3">
                                                <form action="{{ route('plan.show', $plan->id) }}" method="get">
                                                    <button type="submit"
                                                        class="text-gray-600 bg-white hover:bg-gray-200 focus:ring-4 focus:outline-none border border-gray-600 focus:ring-gray-300 font-medium rounded-lg text-lg px-7 py-2 text-center">詳細</button>
                                                </form>
                                            </div>
                                            <button type="button" onclick="openModal({{ $plan->id }})"
                                                class="text-gray-600 bg-white hover:bg-gray-200 focus:ring-4 focus:outline-none border border-gray-600 focus:ring-gray-300 font-medium rounded-lg text-lg px-7 py-2 text-center">
                                                詳細
                                            </button>

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
                            <script>
                                var allReservationDates = {};

                                @foreach ($stayingPlans as $plan)
                                    var countByDate = @json($plan->reservationSlots->groupBy('day')->map->count());
                                    console.log(countByDate);
                                    var idsByDate = @json($plan->reservationSlotStayingPlans->groupBy('reservationSlot.day')->map->first()->pluck('id'));
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
                                @endforeach
                            </script>
                        @endforeach

                        <!-- Modal Start -->
                        <div id="calendarModal"
                            class="fixed top-0 left-0 w-full h-full bg-gray-800 bg-opacity-60 flex justify-center items-center hidden">
                            <div class="bg-white p-5 rounded shadow-lg w-3/4 h-3/4">
                                <div id="calendar"></div>
                            </div>
                        </div>


                    </div>
                </div>

                <div id="roomSection" class="w-full md:px-5" style="display:none;">
                    <div class="md:ml-2 md:mr-4 md:pb-5">
                        <div class="p-3 border border-gray-300 rounded my-5">
                            <div class="flex items-center pb-2 border-b border-gray-300">
                                <img src="{{ asset('svg/human_icon.svg') }}" alt="customIcon" class="ml-0.5 w-4 h-4">
                                <span class="ml-2 text-gray-900 text-sm font-bold">テスト</span>
                            </div>
                            <h2 class="text-red-500 tracking-widest text-xl py-2.5 border-b border-gray-300">
                                テスト </h2>
                            <div class="text-gray-600 inline-flex items-center inline text-sm py-2">
                                更新日:テスト</div>
                            <div class="text-gray-900 text-base my-2">テスト<a href="{{ url('/') }}"
                                    class="text-gray-500 inline-flex items-center inline text-sm underline ml-1.5">
                                    <span class="">続きを読む</span>
                                    <svg class="w-3 h-3 ml-1 transform -rotate-45" fill="none" stroke="currentColor"
                                        viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M14 5l7 7m0 0l-7 7m7-7H3"></path>
                                    </svg>
                                </a></div>
                            <div class="w-1/3 overflow-hidden mt-5 mb-3">
                                <img class="object-cover object-center w-full h-full" src="" alt="onsenImage">
                            </div>
                        </div>
                    </div>
                </div>

                <div id="calendarSection" class="w-full overflow-hidden md:px-5 mb-3 md:mb-0" style="display:none;">
                    <div class="md:ml-3 md:pb-5">
                        <div class="container mx-auto mt-8 border border-gray-300">
                            <div class="flex">
                                <div class="text-sm font-bold bg-red-100 w-1/5 p-2.5 border-r border-b border-gray-300">
                                    住所</div>
                                <div class="text-sm bg-white w-4/5 p-2.5 border-b border-gray-300">
                                    テスト</div>
                            </div>
                            <div class="flex">
                                <div class="text-sm font-bold bg-red-100 w-1/5 p-2.5 border-r border-gray-300">最寄り駅
                                </div>
                                <div class="text-sm bg-white w-4/5 p-2.5">テスト</div>
                            </div>
                        </div>
                    </div>
                </div>



            </section>

        </main>




        <script>
            function openModal(planId) {
                document.getElementById('calendarModal').style.display = 'flex';

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

                // TODO: planIdに基づいて、カレンダーにデータをロードする処理を追加
            }

            function closeModal() {
                document.getElementById('calendarModal').style.display = 'none';
            }
        </script>

        <script>
            window.onload = function() {
                const planButton = document.getElementById('planButton');
                const roomButton = document.getElementById('roomButton');
                const calendarButton = document.getElementById('calendarButton');
                const planSection = document.getElementById('planSection');
                const roomSection = document.getElementById('roomSection');
                const calendarSection = document.getElementById('calendarSection');

                function showSection(sectionToShow) {
                    planSection.style.display = 'none';
                    roomSection.style.display = 'none';
                    calendarSection.style.display = 'none';
                    sectionToShow.style.display = 'block';
                }

                roomButton.addEventListener('click', () => showSection(roomSection));
                planButton.addEventListener('click', () => showSection(planSection));
                calendarButton.addEventListener('click', () => showSection(calendarSection));
            };
        </script>

    </main>
@endsection
