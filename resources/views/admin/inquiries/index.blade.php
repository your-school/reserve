@extends('layouts.admin-layout')

@section('inquiry-link')
@endsection


@section('content')
    <main>
        <section class="px-6 py-10 mx-auto tails-selected-element max-w-2xl">
            <div class="w-full overflow-hidden md:w-3/4 md:pr-5 md:pl-9">
                <div class="py-4 px-5 text-2xl font-bold bg-red-100 mt-5 md:mt-0">お問合せ一覧</div>


                <div class="py-6">
                    <p class="text-base text-gray-700 leading-5">
                        @if ($inquiries->firstItem())
                            <span class="font-medium">{{ $inquiries->firstItem() }}</span>
                            から
                            <span class="font-medium">{{ $inquiries->lastItem() }}</span>
                        @else
                            {{ $inquiries->count() }} 件を表示
                        @endif
                        / 全
                        <span class="font-medium">{{ $inquiries->total() }}</span>
                        件
                    </p>
                </div>

                @foreach ($inquiries as $inquiry)
                    <a href="{{ route('admin.inquiries.show', ['id' => $inquiry->id]) }}" class="w-full md:w-2/3">
                        <div
                            class="border-t hover:bg-gray-200 click:bg-gray-400 rounded @if ($inquiry->status == 2) bg-gray-400 hover:bg-gray-500 @endif">
                            <div class="py-6 px-5 flex flex-wrap">
                                <div class="w-full overflow-hidden">
                                    <div class="mb-3"><span
                                            class="font-semibold text-lg">{{ $inquiry['inquiry_category'] }}のお問い合わせ</span>
                                    </div>
                                    <div class="text-xs my-0.5"><span class="font-medium">お名前 :</span><span
                                            class="ml-1.5 font-medium">{{ $inquiry['first_name'] }}
                                            {{ $inquiry['last_name'] }} 様</div>
                                    @if ($inquiry->status == 0)
                                        <div class="text-xs my-2"><span class="font-medium">対応ステータス :</span><span
                                                class="ml-1.5 font-bold text-red-500">未対応</div>
                                    @elseif($inquiry->status == 1)
                                        <div class="text-xs my-2"><span class="font-medium">対応ステータス :</span><span
                                                class="ml-1.5 font-bold">対応中</div>
                                    @elseif($inquiry->status == 2)
                                        <div class="text-xs my-2"><span class="font-medium">対応ステータス :</span><span
                                                class="ml-1.5">対応済み</div>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </a>
                @endforeach

                <div class="flex flex-row-reverse justify-center pt-5 pb-10">
                    <p class="ml-5">{{ $inquiries->links() }}</p>
                    <p class="text-base text-gray-700 leading-5 pr-4 pt-2.5">
                        表示中
                        @if ($inquiries->firstItem())
                            <span class="font-medium">{{ $inquiries->firstItem() }}</span>
                            から
                            <span class="font-medium">{{ $inquiries->lastItem() }}</span>
                        @else
                            {{ $inquiries->count() }}
                        @endif
                        /
                        <span class="font-medium">{{ $inquiries->total() }}</span>
                        件
                    </p>

                </div>
            </div>

            </div>



        </section>

    </main>
@endsection
