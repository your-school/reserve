@extends('layouts.admin-layout')

@section('inquiry-link')
@endsection


@section('content')
    <main>
        <section class="px-6 py-10 mx-auto tails-selected-element max-w-2xl">
            <h1 class="block text-4xl font-bold text-gray-800 text-black mb-10 text-center">お問い合わせ詳細</h1>

            @if ($inquiry->status == 2)
                <div class="block text-xl font-bold text-red-500  mb-11 text-center border border-red-500 py-2">対応済みのお問い合わせです
                </div>
            @endif
            <div class="mb-8">
                <label for="first_name" class="block mb-2 text-lg font-medium text-black">お名前</label>
                <div class="flex flex-col md:flex-row space-y-4 md:space-y-0 md:space-x-4">
                    <div class="flex flex-col font-bold">
                        {{ $inquiry['first_name'] }} {{ $inquiry['last_name'] }} 様
                    </div>
                </div>
            </div>
            <div class="mb-8">
                <label for="first_name" class="block mb-2 text-lg font-medium text-black">メールアドレス</label>
                <div class="flex flex-col md:flex-row space-y-4 md:space-y-0 md:space-x-4">
                    <div class="flex flex-col font-bold">
                        {{ $inquiry['email'] }}
                    </div>
                </div>
            </div>
            <div class="mb-8">
                <label for="first_name" class="block mb-2 text-lg font-medium text-black">投稿日時</label>
                <div class="flex flex-col md:flex-row space-y-4 md:space-y-0 md:space-x-4">
                    <div class="flex flex-col font-bold">
                        {{ $inquiry['created_at'] }}
                    </div>
                </div>
            </div>
            <div class="mb-8">
                <label for="first_name" class="block mb-2 text-lg font-medium text-black">対応日時</label>
                <div class="flex flex-col md:flex-row space-y-4 md:space-y-0 md:space-x-4">
                    <div class="flex flex-col font-bold">
                        {{ $inquiry['updated_at'] }}
                    </div>
                </div>
            </div>
            <div class="mb-8">
                <label for="first_name" class="block mb-2 text-lg font-medium text-black">お問い合わせ項目</label>
                <div class="flex flex-col md:flex-row space-y-4 md:space-y-0 md:space-x-4">
                    <div class="flex flex-col font-bold">
                        {{ $inquiry['inquiry_category'] }}
                    </div>
                </div>
            </div>
            <div class="mb-8 border-b-2 border-gray-300 pb-20">
                <label for="first_name" class="block mb-2 text-lg font-medium text-black">お問い合わせの内容</label>
                <div class="flex flex-col md:flex-row space-y-4 md:space-y-0 md:space-x-4">
                    <div class="flex flex-col font-bold">
                        {{ $inquiry['content'] }}
                    </div>
                </div>
            </div>

            <form action="{{ route('admin.inquiries.update', $inquiry->id) }}" method="POST">
                @method('PATCH')
                @csrf
                <div class="flex flex-col justify-center items-center mb-8 pb-5 block mt-20">
                    <label for="first_name" class="block mb-2 text-xl font-bold text-black">対応日時</label>
                    <div class="flex flex-col font-semibold text-lg">
                        {{ $inquiry['updated_at'] }}
                    </div>
                </div>
                <div class="flex flex-col justify-center items-center mb-8 pb-5 block">
                    <label for="first_name" class="block mb-3 text-xl font-bold text-black">対応ステータス</label>
                    <select name="status" id="status" class="form-control @error('status') is-invalid @enderror">
                        <option value="0" @if (old('status', $inquiry->status) == 0) selected @endif>未対応
                        </option>
                        <option value="1" @if (old('status', $inquiry->status) == 1) selected @endif>対応中
                        </option>
                        <option value="2" @if (old('status', $inquiry->status) == 2) selected @endif>対応済み
                        </option>
                    </select>
                </div>
                <div class="flex items-center justify-center mb-16">
                    <button type="submit"
                        class="text-white bg-red-500 hover:bg-red-600 focus:ring-4 focus:outline-none focus:ring-red-300 font-medium rounded-lg text-lg px-20 py-3 text-center dark:bg-red-400 dark:hover:bg-red-500 dark:focus:ring-red-600">変更する</button>
                </div>
            </form>
        </section>
    </main>
@endsection
