@extends('layouts.admin-layout')



@section('content')
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
    <main>
        <section class="px-6 py-10 mx-auto tails-selected-element max-w-2xl md:max-w-6xl">
            <div class="w-full overflow-hidden">
                <div class="py-4 px-5 text-2xl font-bold bg-red-100 mt-5 md:mt-0">予約枠一覧</div>


                @foreach ($roomTypes as $roomType => $type)
                    <div class="md:w-1/2 w-full p-4 md:my-8 md:mx-1 my-3 bg-gray-200 rounded">
                        <div class="pb-3 ml-2 text-2xl font-bold">{{ $type }}</div>
                        <div class="bg-white overflow-auto">
                            <table class="min-w-full bg-white">
                                <thead class="bg-gray-800 text-white">
                                    <tr>
                                        <th class="text-center py-3 px-4 uppercase font-semibold text-sm">日時</th>
                                        <th class="text-center py-3 px-4 uppercase font-semibold text-sm">全部屋数</th>
                                        <th class="text-center py-3 px-4 uppercase font-semibold text-sm">残り</th>
                                        <th class="text-center py-3 px-2 uppercase font-semibold text-sm"></th>
                                    </tr>
                                </thead>
                                <tbody class="text-gray-700">
                                    @foreach ($slots[$type] as $day => $daySlots)
                                        <tr class="border-b">
                                            <td class="text-center py-3 px-4">{{ $day }}</td>
                                            <td class="text-center py-3 px-4">{{ $daySlots->count() }}</td> <!-- 部屋数の総数 -->
                                            <td class="text-center py-3 px-4">
                                                {{ $daySlots->whereNull('reservation_id')->count() }}</td>
                                            <!-- 残り部屋数のカウント -->
                                            <td class="text-center py-3 px-2">
                                                <form
                                                    action="{{ route('reservation_slot.delete_by_date', ['room_master_id' => $roomType]) }}"
                                                    method="POST">
                                                    @csrf
                                                    @method('DELETE')
                                                    <input type="hidden" name="date" value="{{ $day }}">
                                                    <button type="submit"
                                                        class="text-white bg-red-500 hover:bg-red-600 focus:ring-4 focus:outline-none focus:ring-red-300 font-medium rounded-lg text-lg py-3 w-32 flex justify-center items-center dark:bg-red-400 dark:hover:bg-red-500 dark:focus:ring-red-600">
                                                        削除
                                                    </button>
                                                </form>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                @endforeach





                <form action="{{ route('reservation_slot.create') }}" method="get">
                    <div class="flex justify-center my-16">
                        <button type="submit"
                            class="text-white bg-red-500 hover:bg-red-600 focus:ring-4 focus:outline-none focus:ring-red-300 font-medium rounded-lg text-lg px-20 py-3 text-center dark:bg-red-400 dark:hover:bg-red-500 dark:focus:ring-red-600">
                            部屋枠を作成する
                        </button>
                    </div>
                </form>
            </div>

        </section>

    </main>
@endsection
