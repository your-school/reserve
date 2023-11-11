@extends('layouts.admin-layout')



@section('content')
    <main>
        <section class="px-6 py-10 mx-auto tails-selected-element max-w-2xl md:max-w-6xl">
            <div class="w-full overflow-hidden">
                <div class="py-4 px-5 text-2xl font-bold bg-red-100 mt-5 md:mt-0">宿泊プラン一覧</div>
                <form action="{{ route('admin.plan.create') }}" method="get">
                    <div class="flex justify-center my-6">
                        <button type="submit"
                            class="text-white bg-red-500 hover:bg-red-600 focus:ring-4 focus:outline-none focus:ring-red-300 font-medium rounded-lg text-lg px-20 py-3 text-center dark:bg-red-400 dark:hover:bg-red-500 dark:focus:ring-red-600">
                            宿泊プランを作成する
                        </button>
                    </div>
                </form>
                @foreach ($plans as $plan)
                    <div class="w-full p-4 md:my-8 md:mx-1 my-3 bg-gray-200 rounded">
                        <div class="flex justify-between">
                            <div class="pb-3 ml-2 text-2xl font-bold">{{ $plan->title }}</div>
                            <div class="flex justify-center items-center">
                                <form action="{{ route('admin.plan.edit', $plan) }}" method="get">
                                    <button type="submit"
                                        class="mx-2 mb-4 text-white bg-blue-500 hover:bg-blue-600 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-lg py-3 w-32 flex justify-center items-center dark:bg-gray-400 dark:hover:bg-gray-500 dark:focus:ring-gray-600">
                                        編集
                                    </button>
                                </form>
                                <form action="{{ route('admin.plan.destroy', $plan) }}" method="POST">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" onclick="return confirm('本当に削除しますか？')"
                                        class="mx-2 mb-4 text-white bg-red-500 hover:bg-red-600 focus:ring-4 focus:outline-none focus:ring-red-300 font-medium rounded-lg text-lg py-3 w-32 flex justify-center items-center dark:bg-red-400 dark:hover:bg-red-500 dark:focus:ring-red-600">
                                        削除
                                    </button>
                                </form>
                            </div>
                        </div>
                        <div class="">
                            <div class="flex mb-5">
                                <div class="w-1/2 mx-2">
                                    <div class="flex flex-col">
                                        <div class="flex">
                                            <div
                                                class="text-sm font-bold bg-red-100 w-1/3 p-2.5 border-r border-b border-gray-300">
                                                説明</div>
                                            <div class="text-sm bg-white w-2/3 p-2.5 border-b border-gray-300">
                                                {{ $plan->explain }} </div>
                                        </div>
                                        <div class="flex">
                                            <div
                                                class="text-sm font-bold bg-red-100 w-1/3 p-2.5 border-r border-b border-gray-300">
                                                販売期間</div>
                                            <div class="text-sm bg-white w-2/3 p-2.5 border-b border-gray-300">
                                                {{ $plan->roomSlots->min('day') }} 〜
                                                {{ $plan->roomSlots->max('day') }}</div>
                                        </div>
                                        <div class="flex">
                                            <div
                                                class="text-sm font-bold bg-red-100 w-1/3 p-2.5 border-r border-b border-gray-300">
                                                お支払い
                                            </div>
                                            <div class="text-sm bg-white w-2/3 p-2.5 border-b border-gray-300">現金のみ</div>
                                        </div>
                                        <div class="flex">
                                            <div class="text-sm font-bold bg-red-100 w-1/3 p-2.5 border-r border-gray-300">
                                                予約可能数
                                            </div>
                                            <div class="text-sm bg-white w-2/3 p-2.5">
                                                {{ $plan->roomSlots->sum('stock') }}</div>
                                        </div>
                                    </div>
                                </div>
                                <div class="w-1/2 mx-2">
                                    @foreach ($plan->planImages as $image)
                                        <img src="{{ asset('/' . $image->image_url) }}" alt="プランの画像">
                                    @endforeach
                                </div>

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
                                    @foreach ($plan->groupedSlots as $plan)
                                        <tbody class="text-gray-700">
                                            <tr class="border-b">
                                                <td class="text-center py-3 px-2">
                                                    {{ $plan['slots']->first()->roomMaster->name }}
                                                    {{-- {{ $plan->reservationSlots->first()->roomMaster->room_type }} --}}
                                                </td>
                                                <td class="text-center py-3 px-4">
                                                    {{ $plan['price'] }}
                                                    {{-- {{ $plan->reservationSlotplans->first() }} --}}
                                                    {{-- {{ $plan->first()->reservationSlotplans->first()->price }} --}}
                                                </td>
                                                <td class="text-center py-3 px-4">
                                                    {{ $plan['slots']->min('day') }}
                                                    {{-- {{ $plan->reservationSlots->first()->day }} --}}
                                                </td>
                                                <td class="text-center py-3 px-4">
                                                    {{ $plan['slots']->max('day') }}
                                                    {{-- {{ $plan->reservationSlots->first()->stock }} --}}
                                                </td>
                                            </tr>
                                        </tbody>
                                    @endforeach
                                </table>
                            </div>
                        </div>
                    </div>
                @endforeach
                <form action="{{ route('admin.plan.create') }}" method="get">
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
