@extends('layouts.layout')

@section('content')
    <main>

        @if (session('success'))
            <div class="flex container mx-auto w-full flex-col text-center my-10">
                <div class="mt-10 bg-green-100 border-t border-b border-green-500 text-green-700 px-4 py-3" role="alert">
                    <p class="font-bold">{{ session('success') }}</p>
                </div>
            </div>
        @endif

        @if (session('error'))
            <div class="flex container mx-auto w-full flex-col text-center my-10">
                <div class="mt-10 bg-red-100 border-t border-b border-red-500 text-red-700 px-4 py-3" role="alert">
                    <p class="font-bold">{{ session('error') }}</p>
                </div>
            </div>
        @endif

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
                {{-- <div class="flex flex-wrap md:flex-nowrap">
                    <div class="w-full overflow-hidden md:w-4/6">
                        <div class="pt-4 pb-2.5 px-0.5">
                            <div class="pt-2"><span class="font-bold text-2xl">テスト</span>
                            </div>
                            <div class="mt-1.5"><span class="text-red-500 text-2xl">テスト</span><span class="ml-1">テスト
                                </span></div>
                        </div>
                        <div class="text-xs my-0.5"><span class="font-bold">都道府県 :</span><span class="ml-1.5">テスト<span
                                    class="ml-4 font-bold">最寄り駅 :</span><span class="ml-1.5">テスト</div>
                        <div class="text-xs my-1"><span class="font-bold">定休日 :</span><span class="ml-1.5">テスト/span>
                                <div class="md:p-3"></div>
                        </div>
                    </div>
                </div> --}}

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
                </div>
            </section>
        </div>
    </main>
@endsection
