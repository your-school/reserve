@extends('layouts.admin-layout')



@section('content')
    <main>
        <section class="px-6 py-10 mx-auto tails-selected-element max-w-2xl md:max-w-6xl">
            <div class="w-full overflow-hidden">
                <div class="py-4 px-5 text-2xl font-bold bg-red-100 mt-5 md:mt-0">予約一覧</div>

                <div class="w-full p-4 md:my-8 md:mx-1 my-3 bg-gray-200 rounded">
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
                                    </tr>
                                </thead>
                                @foreach ($reservations as $reservation)
                                    <tbody class="text-gray-700">
                                        <tr class="border-b">
                                            <td class="text-center py-3 px-2">
                                                {{ $reservation->planRooms->first()->roomSlot->roomMaster->name }}
                                                {{-- {{ $reservation->reservationSlots->first()->roomMaster->room_type }} --}}
                                            </td>
                                            <td class="text-center py-3 px-4">
                                                {{ $reservation->total_price }}
                                                {{-- {{ $reservation->reservationSlotreservations->first() }} --}}
                                                {{-- {{ $reservation->first()->reservationSlotreservations->first()->price }} --}}
                                            </td>
                                            <td class="text-center py-3 px-4">
                                                {{ $reservation->full_name }} {{ $reservation->last_name }}
                                                {{-- {{ $reservation->reservationSlots->first()->day }} --}}
                                            </td>
                                            <td class="text-center py-3 px-4">
                                                {{ $reservation->start_day }}
                                                {{-- {{ $reservation->reservationSlots->first()->stock }} --}}
                                            </td>
                                            <td class="flex justify-center py-3 px-4">
                                                <a href="{{ route('admin.reservation.show', $reservation) }}"
                                                    class="text-white bg-gray-500 hover:bg-gray-600 focus:ring-4 focus:outline-none focus:ring-gray-300 font-medium rounded-lg text-lg py-2 w-24 flex justify-center items-center dark:bg-gray-400 dark:hover:bg-gray-500 dark:focus:ring-gray-600">
                                                    詳細
                                                </a>
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
