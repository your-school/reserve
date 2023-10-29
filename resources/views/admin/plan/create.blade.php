@extends('layouts.admin-layout')



@section('content')
    <main>
        <section class="px-6 py-10 mx-auto tails-selected-element max-w-2xl">
            <div class="w-full overflow-hidden">
                <div class="py-4 px-5 text-2xl font-bold bg-red-100 mt-5 md:mt-0">宿泊プラン作成</div>
                <form action="{{ route('admin.plan.store') }}" method="POST" enctype="multipart/form-data">
                    @method('POST')
                    @csrf
                    <div class="flex-grow flex flex-col inline-flex items-center">
                        <div class="container mx-auto my-8 ml-2">
                            <h1 class="text-2xl font-bold mb-2">部屋タイプ選択</h1>
                            <div>
                                <label>
                                    <input type="checkbox" name="room_master_id[]" value="1">
                                    シングルルーム
                                    <input type="text" name="price[1]"
                                        class="room-input hidden p-2 border rounded-md m-3" placeholder="シングルルームの料金">
                                </label>
                                <br>
                                <label>
                                    <input type="checkbox" name="room_master_id[]" value="2">
                                    ツインルーム
                                    <input type="text" name="price[2]"
                                        class="room-input hidden p-2 border rounded-md m-3" placeholder="ツインルームの料金">
                                </label>
                                <br>
                                <label>
                                    <input type="checkbox" name="room_master_id[]" value="3">
                                    デラックスルーム
                                    <input type="text" name="price[3]"
                                        class="room-input hidden p-2 border rounded-md m-3" placeholder="デラックスルームの料金">
                                </label>
                                <br>
                                <label>
                                    <input type="checkbox" name="room_master_id[]" value="4">
                                    キングルーム
                                    <input type="text" name="price[4]"
                                        class="room-input hidden p-2 border rounded-md m-3" placeholder="キングルームの料金">
                                </label>
                            </div>
                        </div>

                        <div class="container mx-auto my-8">
                            <h1 class="text-2xl font-bold mb-4">日にちの選択</h1>
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
                            <h1 class="text-2xl font-bold mb-4">宿泊プラン名</h1>
                            <div class="flex flex-col space-y-4">
                                <div class="flex flex-col">
                                    <input type="text" id="title" name="title" min="1"
                                        class="p-2 border rounded-md" placeholder="タイトルを入力してください">
                                </div>
                            </div>
                        </div>

                        <div class="container mx-auto my-8">
                            <h1 class="text-2xl font-bold mb-4">内容・説明</h1>
                            <div class="flex flex-col space-y-4">
                                <div class="flex flex-col">
                                    <textarea id="explan" name="explain" min="1" rows="10" cols="4
                                    0"
                                        class="form-control p-2 border rounded-md" placeholder=""></textarea>
                                </div>
                            </div>
                        </div>

                        <div class="container mx-auto my-8">
                            <h1 class="text-2xl font-bold mb-4">画像</h1>
                            <div class="flex flex-col space-y-4">
                                <div class="flex flex-col">
                                    <input type="file" id="image" name="image" class="p-2 border rounded-md"
                                        placeholder="">
                                </div>
                            </div>
                        </div>

                        <div class="flex justify-center my-8">
                            <button type="submit"
                                class="text-white bg-red-500 hover:bg-red-600 focus:ring-4 focus:outline-none focus:ring-red-300 font-medium rounded-lg text-lg px-20 py-3 text-center dark:bg-red-400 dark:hover:bg-red-500 dark:focus:ring-red-600">作成する</button>
                        </div>
                    </div>
                </form>
            </div>
        </section>
    </main>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const checkboxes = document.querySelectorAll('input[type="checkbox"]');

            checkboxes.forEach(function(checkbox) {
                checkbox.addEventListener('change', function() {
                    const input = this.nextElementSibling;
                    if (this.checked) {
                        input.classList.remove('hidden');
                    } else {
                        input.classList.add('hidden');
                    }
                });
            });
        });
    </script>
@endsection
