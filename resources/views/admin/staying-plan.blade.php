@extends('layouts.admin-layout')



@section('content')
    @php
        $roomTypes = [
            '1' => 'シングルルーム',
            '2' => 'ツインルーム',
            '3' => 'デラックスルーム',
            '4' => 'キングルーム',
        ];
    @endphp

    <main>
        <section class="px-6 py-10 mx-auto tails-selected-element max-w-2xl md:max-w-6xl">
            <div class="w-full overflow-hidden">
                <div class="py-4 px-5 text-2xl font-bold bg-red-100 mt-5 md:mt-0">宿泊プラン一覧</div>



                @foreach ($stayingPlans as $plan)
                    <div class="md:w-1/2 w-full p-4 md:my-8 md:mx-1 my-3 bg-gray-200 rounded">
                        <div class="flex justify-between">
                            <div class="pb-3 ml-2 text-2xl font-bold">{{ $plan->title }}</div>
                            <form action="{{ route('staying_plan.destroy', $plan->id) }}" method="POST">
                                @csrf
                                @method('DELETE')
                                <button type="submit"
                                    class="mb-4 text-white bg-red-500 hover:bg-red-600 focus:ring-4 focus:outline-none focus:ring-red-300 font-medium rounded-lg text-lg py-3 w-32 flex justify-center items-center dark:bg-red-400 dark:hover:bg-red-500 dark:focus:ring-red-600">
                                    削除
                                </button>
                            </form>
                        </div>
                        <div class="bg-white overflow-auto">
                            <table class="min-w-full bg-white">
                                <thead class="bg-gray-800 text-white">
                                    <tr>
                                        <th class="text-center py-3 px-2 uppercase font-semibold text-sm">部屋</th>
                                        <th class="text-center py-3 px-4 uppercase font-semibold text-sm">料金</th>
                                        <th class="text-center py-3 px-4 uppercase font-semibold text-sm">開始日</th>
                                        <th class="text-center py-3 px-4 uppercase font-semibold text-sm">終了日</th>
                                    </tr>
                                </thead>
                                <tbody class="text-gray-700">
                                    <tr class="border-b">
                                        <td class="text-center py-3 px-2">
                                            @if ($plan->reservationSlots->isNotEmpty() && isset($roomTypes[$plan->reservationSlots->first()->roomMaster->room_type]))
                                                {{ $roomTypes[$plan->reservationSlots->first()->roomMaster->room_type] }}
                                            @endif
                                        </td>
                                        <td class="text-center py-3 px-4">
                                            {{ $plan->reservationSlotStayingPlans->first()->price }}
                                        </td>
                                        <td class="text-center py-3 px-4">
                                            @if ($plan->reservationSlots->isNotEmpty())
                                                {{ $plan->reservationSlots->min('day') }} {{-- 最も早い日付 --}}
                                            @endif
                                        </td>
                                        <td class="text-center py-3 px-4">
                                            @if ($plan->reservationSlots->isNotEmpty())
                                                {{ $plan->reservationSlots->max('day') }} {{-- 最も遅い日付 --}}
                                            @endif
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                @endforeach





                <form action="{{ route('staying_plan.create') }}" method="get">
                    <div class="flex justify-center my-16">
                        <button type="submit"
                            class="text-white bg-red-500 hover:bg-red-600 focus:ring-4 focus:outline-none focus:ring-red-300 font-medium rounded-lg text-lg px-20 py-3 text-center dark:bg-red-400 dark:hover:bg-red-500 dark:focus:ring-red-600">
                            宿泊プランを作成する
                        </button>
                    </div>
                </form>
            </div>

        </section>

    </main>
@endsection
