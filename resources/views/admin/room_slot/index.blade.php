@extends('layouts.admin-layout')



@section('content')
    <main>
        <section class="px-6 py-10 mx-auto tails-selected-element max-w-2xl md:max-w-6xl">
            <div class="w-full overflow-hidden">
                <div class="py-4 px-5 text-2xl font-bold bg-red-100 mt-5 md:mt-0">予約枠一覧</div>

                <form action="{{ route('admin.room_slot.create') }}" method="get">
                    <div class="flex justify-center my-16">
                        <button type="submit"
                            class="text-white bg-red-500 hover:bg-red-600 focus:ring-4 focus:outline-none focus:ring-red-300 font-medium rounded-lg text-lg px-20 py-3 text-center dark:bg-red-400 dark:hover:bg-red-500 dark:focus:ring-red-600">
                            部屋枠を作成する
                        </button>
                    </div>
                </form>
                @foreach ($roomTypes as $roomType)
                    <div class=" p-4 md:my-20 md:mx-1 my-3 bg-gray-200 rounded">
                        <div class="pb-3 ml-2 text-2xl font-bold">{{ $roomType->name }}</div>
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
                                    @foreach ($slots[$roomType->id] as $roomSlot)
                                        <tr class="border-b">
                                            <td class="text-center py-3 px-4">{{ $roomSlot->day }}</td>
                                            <td class="text-center py-3 px-4">
                                                <form action="{{ route('admin.room_slot.update', $roomSlot) }}"
                                                    method="POST" class="flex justify-center space-x-3">
                                                    @csrf
                                                    @method('PATCH')
                                                    <input type="number" id="stock" name="stock"
                                                        value="{{ $roomSlot->stock }}" class="p-1 border rounded-md w-1/4">
                                                    <button type="submit"
                                                        class="text-white bg-red-500 hover:bg-red-600 focus:ring-4 focus:outline-none focus:ring-red-300 font-medium rounded-lg text-lg py-3 w-24 flex justify-center items-center dark:bg-red-400 dark:hover:bg-red-500 dark:focus:ring-red-600">
                                                        変更
                                                    </button>
                                                </form>
                                            </td>

                                            <td class="text-center py-3 px-4">
                                            </td>
                                            <td class="text-center py-3 px-2">
                                                <form action="{{ route('admin.room_slot.destroy', $roomSlot) }}"
                                                    method="POST">
                                                    @csrf
                                                    @method('DELETE')
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

                <form action="{{ route('admin.room_slot.create') }}" method="get">
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
