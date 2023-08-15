@extends('layouts.layout')

@section('inquiry-link')
@endsection

@section('modal-inquiry-link')
@endsection


@section('content')
    <main>
        <section class="px-6 py-10 mx-auto tails-selected-element max-w-2xl">
            <form id="inquiry-form" method="POST" action="/inquiry/store" enctype="multipart/form-data">
                @csrf

                <h1 class="block text-4xl font-bold text-gray-800 text-black mb-11 text-center">お問合せフォーム </h1>

                <div class="mb-8">
                    @if ($errors->any())
                        <ul>
                            @foreach ($errors->all() as $error)
                                <li>・{{ $error }}</li>
                            @endforeach
                        </ul>
                    @endif
                </div>

                <div class="mb-8">
                    <label for="first_name" class="block mb-2 text-sm font-medium text-black">苗字:</label>
                    <input id="autocomplete" type="text" name='first_name' placeholder="苗字をご入力ください"
                        class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500">
                </div>

                <div class="mb-8">
                    <label for="last_name" class="block mb-2 text-sm font-medium text-black">名前:</label>
                    <input id="autocomplete" type="text" name='last_name' placeholder="お名前をご入力ください"
                        class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500">
                </div>

                <div class="mb-8">
                    <label for="email" class="block mb-2 text-sm font-medium text-black">メールアドレス</label>
                    <input id="autocomplete" type="email" name='email' placeholder="メールアドレスをご入力ください"
                        class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500">
                </div>

                <div class="mb-8">
                    <label class="block mb-2 text-sm font-medium text-black">お問合せ項目:</label>
                    <select name='inquiry_category'
                        class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500">
                        <option value="" selected>選択してください</option>
                        <option value="プランについて">プランについて</option>
                        <option value="宿泊について">宿泊について</option>
                        <option value="部屋について">部屋について</option>
                        <option value="日時について">日時について</option>
                        <option value="予約について">予約について</option>
                        <option value="その他">その他</option>
                    </select>
                </div>

                <div class="mb-8">
                    <label class="block mb-2 text-sm font-medium text-black">お問合せ内容:</label>
                    <textarea name='content'
                        class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                        maxlength='3000' row='4'></textarea>
                </div>

                <div class="flex justify-center my-16">
                    <button type="submit"
                        class="text-white bg-red-500 hover:bg-red-600 focus:ring-4 focus:outline-none focus:ring-red-300 font-medium rounded-lg text-lg px-20 py-3 text-center dark:bg-red-400 dark:hover:bg-red-500 dark:focus:ring-red-600">お問合せを送る</button>
                </div>

            </form>
        </section>
    </main>
@endsection
