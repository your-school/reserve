@extends('layouts.admin-layout')

@section('inquiry-link')
@endsection


@section('content')
    <main>

        @if (session('success'))
            <div class="flex container mx-auto w-full flex-col text-center my-10">
                <div class="mt-10 bg-red-100 border-t border-b border-red-500 text-red-700 px-4 py-3" role="alert">
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


        <main class="max-w-6xl px-5 py-5 md:py-10 mx-auto md:px-10 tails-selected-element">


            <section class="flex flex-wrap overflow-hidden md:px-0">

                <div class="p-12 md:w-1/2 flex flex-col items-start">
                    <div class="w-full overflow-hidden md:w-4/6">
                        <div class="my-4"><span class="font-bold text-2xl">苗字 :</span><span
                                class="ml-1.5">{{ $inquiry['first_name'] }}</div>
                        <div class="my-4"><span class="font-bold text-2xl">名前 :</span><span
                                class="ml-1.5">{{ $inquiry['last_name'] }}</div>
                        <div class="my-4"><span class="font-bold text-2xl">メールアドレス :</span><span
                                class="ml-1.5">{{ $inquiry['email'] }}</div>
                        <div class="my-4"><span class="font-bold text-2xl">投稿日時 :</span><span
                                class="ml-1.5">{{ $inquiry['created_at'] }}</div>
                        <div class="my-4"><span class="font-bold text-2xl">対応日時 :</span><span
                                class="ml-1.5">{{ $inquiry['updated_at'] }}</div>
                    </div>
                </div>
                <div class="p-12 md:w-1/2 flex flex-col items-start">
                    <h2 class="sm:text-3xl title-font font-bold text-2xl text-gray-900 mt-4 mb-4">
                        {{ $inquiry['inquiry_category'] }}</h2>
                    <p class="leading-relaxed mb-8">{{ $inquiry['content'] }}</p>
                    <div class="flex items-center flex-wrap pb-4 mb-4 border-b-2 border-gray-100 mt-auto w-full">
                        <a class="text-indigo-500 inline-flex items-center">
                    </div>
                    <form action="{{ route('inquiries.update', $inquiry->id) }}" method="POST">
                        @method('PATCH')
                        @csrf
                        <a class="inline-flex items-center">
                            <span class="flex-grow flex flex-col pl-4">
                                <span class="title-font font-medium text-gray-900">対応ステータス</span>
                                <div>
                                    <select name="status" id="status"
                                        class="form-control @error('status') is-invalid @enderror">
                                        <option value="0" @if (old('status', $inquiry->status) == 0) selected @endif>未対応
                                        </option>
                                        <option value="1" @if (old('status', $inquiry->status) == 1) selected @endif>対応中
                                        </option>
                                        <option value="2" @if (old('status', $inquiry->status) == 2) selected @endif>対応済み
                                        </option>
                                    </select>
                                </div>
                                <div class="flex justify-center my-8">
                                    <button type="submit"
                                        class="text-white bg-red-500 hover:bg-red-600 focus:ring-4 focus:outline-none focus:ring-red-300 font-medium rounded-lg text-lg px-20 py-3 text-center dark:bg-red-400 dark:hover:bg-red-500 dark:focus:ring-red-600">変更する</button>
                                </div>
                            </span>
                        </a>
                    </form>
                </div>

            </section>

        </main>

    </main>
@endsection
