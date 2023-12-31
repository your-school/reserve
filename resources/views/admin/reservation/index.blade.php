@extends('layouts.admin-layout')



@section('content')
    <main>
        <section class="px-6 py-10 mx-auto tails-selected-element max-w-2xl md:max-w-6xl">
            <div class="w-full overflow-hidden">
                <div class="w-full mb-12">
                    <div class="p-3 border border-gray-300 rounded my-5  bg-gray-100">
                        <div class="flex items-center pb-2 border-b border-gray-300 mb-5">
                            {{-- <img src="{{ asset('svg/human_icon.svg') }}" alt="customIcon" class="ml-0.5 w-4 h-4"> --}}
                            <span class="ml-2 text-gray-900 text-lg font-bold">詳細検索
                            </span>
                        </div>
                        <form action="{{ route('admin.reservation.search') }}" method="POST">
                            @csrf
                            <div class="container mx-auto my-8 flex justify-center">
                                <h1 class="text-lg font-bold mr-6 mt-2">日付</h1>
                                <div class="flex flex-col md:flex-row space-y-4 md:space-y-0 md:space-x-4">
                                    <div class="flex flex-col">
                                        <input type="date" id="start_day" name="start_day" class="p-2 border rounded-md"
                                            value="{{ session('startDate') }}">
                                    </div>
                                    <div class="flex flex-col p-2">〜
                                    </div>
                                    <div class="flex flex-col">
                                        <input type="date" id="end_day" name="end_day" class="p-2 border rounded-md"
                                            value="{{ session('endDate') }}">
                                    </div>
                                </div>
                            </div>
                            <div class="flex justify-center my-8">
                                <button type="submit"
                                    class="mx-2 text-white bg-gray-400 hover:bg-gray-500 focus:ring-4 focus:outline-none focus:ring-gray-300 font-medium rounded-lg text-lg px-10 py-3 text-center">検索</button>
                                @if (isset($searchedString))
                                    <a href="{{ route('admin.reservation.index') }}"
                                        class="mx-2 text-white bg-red-400 hover:bg-red-500 focus:ring-4 focus:outline-none focus:ring-red-300 font-medium rounded-lg text-lg px-10 py-3 text-center">
                                        リセットする
                                    </a>
                                @endif
                            </div>
                        </form>
                    </div>
                </div>
                <div class="py-4 px-5 text-2xl font-bold bg-blue-100 mt-5 md:mt-0">
                    @if (isset($searchedString))
                        {{ $searchedString . 'の' }}
                    @endif
                    予約一覧
                </div>
                <div class="mt-5">
                    <a href="{{ route('admin.reservation.today') }}"
                        class="text-lg mx-2 text-center text-blue-500 hover:text-blue-700 border-b border-blue-500 hover:border-blue-700">
                        本日の予約
                    </a>
                    /
                    <a href="{{ route('admin.reservation.nextday') }}"
                        class="text-lg mx-2 text-center text-blue-500 hover:text-blue-700 border-b border-blue-500 hover:border-blue-700">
                        明日の予約
                    </a>
                </div>

                <div class="w-full p-4 md:my-6 md:mx-1 my-3 bg-gray-200 rounded">
                    <div class="">
                        <div class="bg-white overflow-auto">
                            <table class="min-w-full bg-white">
                                <thead class="bg-gray-800 text-white">
                                    <tr>
                                        <th class="text-center py-3 px-2 uppercase font-semibold text-sm">部屋</th>
                                        <th class="text-center py-3 px-4 uppercase font-semibold text-sm">料金</th>
                                        <th class="text-center py-3 px-4 uppercase font-semibold text-sm">名前</th>
                                        <th class="text-center py-3 px-4 uppercase font-semibold text-sm">宿泊日</th>
                                        <th class="text-center py-3 px-4 uppercase font-semibold text-sm">詳細</th>
                                        <th class="text-center py-3 px-4 uppercase font-semibold text-sm">チェックインSTS</th>
                                    </tr>
                                </thead>
                                @foreach ($reservations as $reservation)
                                    <tbody class="text-gray-700">
                                        @php
                                            $startDay = \Carbon\Carbon::parse($reservation->start_day);
                                        @endphp
                                        <tr
                                            class="border-b 
                                            @if ($startDay->isToday() && $reservation->reservation_status == 1) bg-blue-500
                                            @elseif ($startDay->isToday())
                                                bg-blue-300
                                            @elseif ($startDay->isPast() && $reservation->reservation_status == 0) 
                                                bg-red-300 
                                            @elseif ($startDay->isPast())
                                                bg-gray-400 @endif">
                                            <td class="text-center py-3 px-2">
                                                {{ $reservation->roomName }}
                                                {{-- {{ $reservation->reservationSlots->first()->roomMaster->room_type }} --}}
                                            </td>
                                            <td class="text-center py-3 px-4">
                                                {{ number_format($reservation->total_price) }}円
                                                {{-- {{ $reservation->reservationSlotreservations->first() }} --}}
                                                {{-- {{ $reservation->first()->reservationSlotreservations->first()->price }} --}}
                                            </td>
                                            <td class="text-center py-3 px-4">
                                                {{ $reservation->first_name }} {{ $reservation->last_name }}様
                                                {{-- {{ $reservation->reservationSlots->first()->day }} --}}
                                            </td>
                                            <td class="text-center py-3 px-4">
                                                {{ $reservation->start_day }}~{{ $reservation->end_day }}
                                                {{-- {{ $reservation->reservationSlots->first()->stock }} --}}
                                            </td>
                                            <td class="flex justify-center py-3 px-4">
                                                <a href="{{ route('admin.reservation.show', $reservation) }}"
                                                    class="text-white bg-gray-500 hover:bg-gray-600 focus:ring-4 focus:outline-none focus:ring-gray-300 font-medium rounded-lg text-lg py-2 w-24 flex justify-center items-center dark:bg-gray-400 dark:hover:bg-gray-500 dark:focus:ring-gray-600">
                                                    詳細
                                                </a>
                                            </td>
                                            <td class="justify-center py-3">
                                                @if ($reservation->cancel_flag == 1)
                                                    <span class="text-red-800"> キャンセル済みです</span>
                                                @elseif ($reservation->reservation_status == 0)
                                                    <form action="{{ route('admin.reservation.check_in', $reservation) }}"
                                                        method="POST">
                                                        @csrf
                                                        <button type="submit" onclick="return confirm('CI済みにしますか？')"
                                                            class="text-white bg-blue-600 hover:bg-blue-700 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-lg py-2 w-36 flex justify-center items-center dark:bg-blue-400 dark:hover:bg-blue-500 dark:focus:ring-red-600">
                                                            CI済みにする
                                                        </button>
                                                    </form>
                                                @else
                                                    CI済みです
                                                @endif
                                            </td>
                                        </tr>
                                    </tbody>
                                @endforeach
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </main>
@endsection
