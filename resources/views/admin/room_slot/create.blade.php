@extends('layouts.admin-layout')



@section('content')
    <main>
        <section class="px-6 py-10 mx-auto tails-selected-element max-w-2xl">
            <div class="w-full overflow-hidden">
                <div class="py-4 px-5 text-2xl font-bold bg-blue-100 mt-5 md:mt-0">予約枠作成</div>

                <form action="{{ route('admin.room_slot.store') }}" method="POST">
                    @method('POST')
                    @csrf
                    <div class="flex-grow flex flex-col inline-flex items-center">
                        <div class="container mx-auto my-8">
                            <h1 class="text-2xl font-bold mb-2">部屋タイプ選択</h1>
                            @foreach ($roomTypes as $roomType)
                                <div>
                                    <input type="checkbox" name="room_type_id[]" value="{{ $roomType->id }}"
                                        id="room_master_id_{{ $roomType->id }}">
                                    <label for="room_master_id_{{ $roomType->id }}">{{ $roomType->name }}</label>
                                </div>
                            @endforeach
                        </div>

                        <div class="container mx-auto my-8">
                            <h1 class="text-2xl font-bold mb-4">日にちを指定してください</h1>
                            <div class="flex flex-col md:flex-row space-y-4 md:space-y-0 md:space-x-4">
                                <div class="flex flex-col">
                                    <label for="start_day" class="text-lg mb-2">開始日:</label>
                                    <input type="date" id="start_day" name="start_day" class="p-2 border rounded-md"
                                        min="{{ today()->format('Y-m-d') }}">
                                </div>
                                <div class="flex flex-col">
                                    <label for="end_day" class="text-lg mb-2">終了日:</label>
                                    <input type="date" id="end_day" name="end_day" class="p-2 border rounded-md"
                                        min="{{ today()->format('Y-m-d') }}">
                                </div>
                            </div>
                        </div>

                        <div class="container mx-auto my-8">
                            <h1 class="text-2xl font-bold mb-4">部屋数を指定してください</h1>
                            <div class="flex flex-col space-y-4">
                                <div class="flex flex-col">
                                    <label for="stock" class="text-lg mb-2">部屋数:</label>
                                    <input type="number" id="stock" name="stock" min="1" max="100"
                                        class="p-2 border rounded-md">
                                </div>
                            </div>
                        </div>

                        <div class="flex justify-center my-8">
                            <button type="submit"
                                class="text-white bg-blue-500 hover:bg-blue-600 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-lg px-20 py-3 text-center dark:bg-blue-400 dark:hover:bg-blue-500 dark:focus:ring-blue-600">変更する</button>
                        </div>
                    </div>
                </form>


            </div>

        </section>

    </main>
@endsection
