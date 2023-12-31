@extends('layouts.admin-layout')



@section('content')
    <main>
        <section class="px-6 py-10 mx-auto tails-selected-element max-w-2xl md:max-w-6xl">
            <div class="w-full overflow-hidden">
                <div class="py-4 px-5 text-2xl font-bold bg-blue-100 mt-5 md:mt-0">
                    「{{ $planRooms->first()->plan->title }}」の「{{ $planRooms->first()->roomSlot->roomMaster->name }}」の編集
                </div>
                <div class="">
                    <div class="container mx-auto my-8 ml-2">
                        <div class="bg-white overflow-auto ">
                            <table class="min-w-full bg-white">
                                <thead class="bg-gray-800 text-white">
                                    <tr>
                                        <th class="text-center py-3 px-2 uppercase font-semibold text-sm">日にち</th>
                                        <th class="text-center py-3 px-4 uppercase font-semibold text-sm">料金</th>
                                        <th class="text-center py-3 px-2 uppercase font-semibold text-sm"></th>
                                    </tr>
                                </thead>
                                @foreach ($planRooms as $planRoom)
                                    <tbody class="text-gray-700">
                                        <tr class="border-b">
                                            <td class="text-center py-3 px-2">
                                                {{ $planRoom->roomSlot->day }}
                                            </td>
                                            <td class="text-center py-3 px-4">
                                                <form action="{{ route('admin.plan.charge.update', $planRoom) }}"
                                                    method="POST" class="flex justify-center space-x-3">
                                                    @csrf
                                                    <input type="number" id="price" name="price" required
                                                        value="{{ $planRoom->price }}" class="p-1 border rounded-md w-1/4">
                                                    <button type="submit"
                                                        class="text-white bg-indigo-500 hover:bg-indigo-600 focus:ring-4 focus:outline-none focus:ring-indigo-300 font-medium rounded-lg text-lg py-3 w-24 flex justify-center items-center">
                                                        料金変更
                                                    </button>
                                                </form>
                                            </td>
                                            <td class="text-center py-3 px-4">
                                                <form action="{{ route('admin.plan.delete.one', $planRoom) }}"
                                                    method="POST">
                                                    @csrf
                                                    <button type="submit" onclick="return confirm('本当に削除しますか？')"
                                                        class="px-4 mb-4 text-white bg-red-500 hover:bg-red-600 focus:ring-4 focus:outline-none focus:ring-red-300 font-medium rounded-lg text-lg py-3 w-32 flex justify-center items-center dark:bg-red-400 dark:hover:bg-red-500 dark:focus:ring-red-600">
                                                        削除
                                                    </button>
                                                </form>
                                            </td>
                                        </tr>
                                    </tbody>
                                @endforeach
                            </table>
                        </div>
                    </div>

                    <div class="flex justify-center my-8">
                        <a href="{{ route('admin.plan.index') }}"
                            class="text-white bg-blue-500 hover:bg-blue-600 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-lg px-20 py-3 text-center dark:bg-blue-400 dark:hover:bg-blue-500 dark:focus:ring-blue-600">プラン一覧に戻る</a>
                    </div>
                </div>
            </div>
        </section>
    </main>
@endsection
