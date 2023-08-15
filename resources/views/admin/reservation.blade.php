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
                <div class="py-4 px-5 text-2xl font-bold bg-red-100 mt-5 md:mt-0">予約者一覧</div>





            </div>

        </section>

    </main>
@endsection
