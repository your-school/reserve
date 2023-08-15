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
        <section class="px-6 py-10 mx-auto tails-selected-element max-w-2xl">
            <div class="w-full overflow-hidden">
                <div class="py-4 px-5 text-2xl font-bold bg-red-100 mt-5 md:mt-0">予約枠作成</div>

                <form action="{{ route('reservation_slot.store') }}" method="POST">
                    @method('POST')
                    @csrf
                    <div class="flex-grow flex flex-col inline-flex items-center">
                        <div class="container mx-auto my-8">
                            <h1 class="text-2xl font-bold mb-2">部屋タイプ選択</h1>
                            <div>
                                <label>
                                    <input type="checkbox" name="room_master_id[]" value="1">
                                    シングルルーム
                                </label>
                                <br>
                                <label>
                                    <input type="checkbox" name="room_master_id[]" value="2">
                                    ツインルーム
                                </label>
                                <br>
                                <label>
                                    <input type="checkbox" name="room_master_id[]" value="3">
                                    デラックスルーム
                                </label>
                                <br>
                                <label>
                                    <input type="checkbox" name="room_master_id[]" value="4">
                                    キングルーム
                                </label>
                            </div>
                        </div>

                        <div class="container mx-auto my-8">
                            <h1 class="text-2xl font-bold mb-4">日にちを指定してください</h1>
                            <div class="flex flex-col md:flex-row space-y-4 md:space-y-0 md:space-x-4">
                                <div class="flex flex-col">
                                    <label for="start_day" class="text-lg mb-2">開始日:</label>
                                    <input type="date" id="start_day" name="start_day" class="p-2 border rounded-md">
                                </div>
                                <div class="flex flex-col">
                                    <label for="end_day" class="text-lg mb-2">終了日:</label>
                                    <input type="date" id="end_day" name="end_day" class="p-2 border rounded-md">
                                </div>
                            </div>
                        </div>

                        <div class="container mx-auto my-8">
                            <h1 class="text-2xl font-bold mb-4">部屋数を指定してください</h1>
                            <div class="flex flex-col space-y-4">
                                <div class="flex flex-col">
                                    <label for="room_count" class="text-lg mb-2">部屋数:</label>
                                    <input type="number" id="room_count" name="room_count" min="1" max="200"
                                        class="p-2 border rounded-md">
                                </div>
                            </div>
                        </div>

                        <div class="flex justify-center my-8">
                            <button type="submit"
                                class="text-white bg-red-500 hover:bg-red-600 focus:ring-4 focus:outline-none focus:ring-red-300 font-medium rounded-lg text-lg px-20 py-3 text-center dark:bg-red-400 dark:hover:bg-red-500 dark:focus:ring-red-600">変更する</button>
                        </div>
                    </div>
                </form>


            </div>

        </section>

    </main>
@endsection
