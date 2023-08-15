@extends('layouts.layout')

@section('home-link')
@endsection

@section('modal-home-link')
@endsection


@section('content')
    <main>
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

        <section class="px-5 py-10 mx-auto tails-selected-element max-w-7xl">
            <div class="container">
                <div class="row">
                    <h1>TOPページ</h1>
                </div>
            </div>
        </section>
    </main>
@endsection
