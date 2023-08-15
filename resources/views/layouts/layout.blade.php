<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name') }}</title>

    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.gstatic.com">
    <link href="https://fonts.bunny.net/css?family=Nunito" rel="stylesheet">
    <link rel="stylesheet"
        href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.12.0-2/css/fontawesome.min.css" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.12.0-2/css/all.min.css" />
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.15.4/css/all.css">

    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <script src="https://ajax.aspnetcdn.com/ajax/jQuery/jquery-3.4.1.min.js"></script>
    <script src="https://unpkg.com/flowbite@1.4.0/dist/flowbite.js"></script>


    {{-- <link rel="icon" href="{{ asset('favicon.png') }}" type="image/png"> --}}
</head>



<body>

    <header x-data="{ open: false }"
        class="fixed inset-x-0 top-0 z-50 py-2 bg-gradient-to-br from-red-600 via-indigo-00 to-red-300 tails-selected-element mx-auto"
        data-primary="red-500" data-tails-scripts="//unpkg.com/alpinejs">
        <div class="flex items-center justify-between h-20 px-8 mx-auto max-w-7xl">




            <a class="relative z-10 flex items-center w-auto text-2xl font-extrabold leading-none text-white select-none"
                href="{{ url('/') }}">
                <span class="ml-3 text-xl">予約システム</span>
            </a>

            <nav class="items-center justify-center hidden space-x-7 text-white md:flex">
                @section('home-link')
                    <a href="{{ url('/') }}" x-data="{ hover: false }" @mouseenter="hover = true"
                        @mouseleave="hover = false"
                        class="relative inline-block text-sm font-bold hover:text-gray-200 uppercase transition duration-150 lg:text-base ease text-white">
                        <span class="block">ホーム</span>
                        <span class="absolute bottom-0 left-0 inline-block w-full h-1 -mb-1 overflow-hidden">
                            <span x-show="hover"
                                class="absolute inset-0 inline-block w-full h-full transform border-t-2 border-red-200"
                                x-transition:enter="transition ease-out duration-300"
                                x-transition:enter-start="-translate-x-full" x-transition:enter-end="translate-x-0"
                                x-transition:leave="transition ease-out duration-300"
                                x-transition:leave-start="translate-x-0" x-transition:leave-end="translate-x-full"
                                data-primary="red-600" style="display: none;"></span>
                        </span>
                    </a>
                @show

                @section('guide-link')
                    <a href="{{ url('/access_guide') }}" x-data="{ hover: false }" @mouseenter="hover = true"
                        @mouseleave="hover = false"
                        class="relative inline-block text-sm font-bold hover:text-gray-200 uppercase transition duration-150 lg:text-base ease text-white">
                        <span class="block">アクセス案内</span>
                        <span class="absolute bottom-0 left-0 inline-block w-full h-1 -mb-1 overflow-hidden">
                            <span x-show="hover"
                                class="absolute inset-0 inline-block w-full h-1 h-full transform border-t-2 border-red-200"
                                x-transition:enter="transition ease-out duration-300"
                                x-transition:enter-start="-translate-x-full" x-transition:enter-end="translate-x-0"
                                x-transition:leave="transition ease-out duration-300"
                                x-transition:leave-start="translate-x-0" x-transition:leave-end="translate-x-full"
                                data-primary="red-600" style="display: none;"></span>
                        </span>
                    </a>
                @show

                <a href="{{ route('plan.index') }}" x-data="{ hover: false }" @mouseenter="hover = true"
                    @mouseleave="hover = false"
                    class="relative inline-block text-sm font-bold hover:text-gray-200 uppercase transition duration-150 lg:text-base ease text-white">
                    <span class="block">宿泊プラン一覧</span>
                    <span class="absolute bottom-0 left-0 inline-block w-full h-1 -mb-1 overflow-hidden">
                        <span x-show="hover"
                            class="absolute inset-0 inline-block w-full h-1 h-full transform border-t-2 border-red-200"
                            x-transition:enter="transition ease-out duration-300"
                            x-transition:enter-start="-translate-x-full" x-transition:enter-end="translate-x-0"
                            x-transition:leave="transition ease-out duration-300"
                            x-transition:leave-start="translate-x-0" x-transition:leave-end="translate-x-full"
                            data-primary="red-600" style="display: none;"></span>
                    </span>
                </a>

                @guest

                    @section('inquiry-link')
                        <a href="{{ url('/inquiry') }}" x-data="{ hover: false }" @mouseenter="hover = true"
                            @mouseleave="hover = false"
                            class="relative inline-block text-sm font-bold hover:text-gray-200 uppercase transition duration-150 lg:text-base ease text-white">
                            <span class="block">お問合せフォーム</span>
                            <span class="absolute bottom-0 left-0 inline-block w-full h-1 -mb-1 overflow-hidden">
                                <span x-show="hover"
                                    class="absolute inset-0 inline-block w-full h-1 h-full transform border-t-2 border-red-200"
                                    x-transition:enter="transition ease-out duration-300"
                                    x-transition:enter-start="-translate-x-full" x-transition:enter-end="translate-x-0"
                                    x-transition:leave="transition ease-out duration-300"
                                    x-transition:leave-start="translate-x-0" x-transition:leave-end="translate-x-full"
                                    data-primary="red-600" style="display: none;"></span>
                            </span>
                        </a>
                    @show

                    <a href="{{ route('login') }}" x-data="{ hover: false }" @mouseenter="hover = true"
                        @mouseleave="hover = false"
                        class="relative inline-block text-sm font-bold hover:text-gray-200 uppercase transition duration-150 lg:text-base ease text-white">
                        <span class="block">ログイン</span>
                        <span class="absolute bottom-0 left-0 inline-block w-full h-1 -mb-1 overflow-hidden">
                            <span x-show="hover"
                                class="absolute inset-0 inline-block w-full h-1 h-full transform border-t-2 border-red-200"
                                x-transition:enter="transition ease-out duration-300"
                                x-transition:enter-start="-translate-x-full" x-transition:enter-end="translate-x-0"
                                x-transition:leave="transition ease-out duration-300"
                                x-transition:leave-start="translate-x-0" x-transition:leave-end="translate-x-full"
                                data-primary="red-600" style="display: none;"></span>
                        </span>
                    </a>
                @endguest

                @auth
                    <a href="{{ route('logout') }}"
                        onclick="event.preventDefault();
            		document.getElementById('logout-form').submit();"
                        class="relative inline-flex items-center justify-start px-4 py-3 overflow-hidden font-medium transition-all bg-red-500 rounded-xl group">
                        <span
                            class="absolute top-0 right-0 inline-block w-4 h-4 transition-all duration-500 ease-in-out bg-red-700 rounded group-hover:-mr-4 group-hover:-mt-4">
                            <span
                                class="absolute top-0 right-0 w-5 h-5 rotate-45 translate-x-1/2 -translate-y-1/2 bg-white"></span>
                        </span>
                        <span
                            class="absolute bottom-0 left-0 w-full h-full transition-all duration-500 ease-in-out delay-200 -translate-x-full translate-y-full bg-red-600 rounded-2xl group-hover:mb-12 group-hover:translate-x-0"></span>
                        <span
                            class="relative inline-flex items-center w-full text-left text-white transition-colors duration-200 ease-in-out group-hover:text-white">
                            <svg class="h-6 w-6 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"
                                xmlns="http://www.w3.org/2000/svg">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1">
                                </path>
                            </svg>ログアウト</span>
                    </a>
                    <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                        @csrf
                    </form>
                @endauth

            </nav>


        </div>
    </header>

    @section('remove-in-register-link')
        <div class="mt-24"></div>
    @show

    @yield('content')

    <footer class="bg-gray-100">
        <div class="container px-5 py-6 mx-auto flex items-center sm:flex-row flex-col mx-auto max-w-7xl">
            <a href="{{ url('/') }}"
                class="flex title-font font-medium items-center text-gray-900 mb-4 md:mb-0">
                <span class="ml-3 text-xl">予約システム</span>
            </a>
            <p class="text-sm text-gray-500 sm:ml-6 sm:mt-0 mt-4">© 2023 Tobiyama Kosuke —
                <a rel="noopener noreferrer" class="text-gray-600 ml-1" target="_blank">@Tobikous</a>
            </p>
            <span class="inline-flex sm:ml-auto sm:mt-0 mt-4 justify-center sm:justify-start">

                <a href="{{ url('/') }}"
                    class="ml-3 text-sm text-gray-500 transition-colors duration-300 hover:text-gray-700"
                    aria-label="Reddit"> 会員規約 </a>
                <a href="{{ url('/') }}"
                    class="ml-3 text-sm text-gray-500 transition-colors duration-300 hover:text-gray-700"
                    aria-label="Reddit"> プライバシーポリシー </a>
                <a href="{{ url('/') }}"
                    class="ml-3 text-sm text-gray-500 transition-colors duration-300 hover:text-gray-700"
                    aria-label="Reddit"> お問い合わせ </a>
                <a href="https://twitter.com/tobikouov" class="ml-5 text-gray-500 hover:text-gray-700"
                    target="_blank">
                    <svg fill="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        class="w-5 h-5" viewBox="0 0 24 24">
                        <path
                            d="M23 3a10.9 10.9 0 01-3.14 1.53 4.48 4.48 0 00-7.86 3v1A10.66 10.66 0 013 4s-4 9 5 13a11.64 11.64 0 01-7 2c9 5 20 0 20-11.5a4.5 4.5 0 00-.08-.83A7.72 7.72 0 0023 3z">
                        </path>
                    </svg>
                </a>
                <a href="https://www.linkedin.com/in/tobiyama-a40369271"
                    class="ml-3 text-gray-500 hover:text-gray-700" target="_blank">
                    <svg fill="currentColor" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"
                        stroke-width="0" class="w-5 h-5" viewBox="0 0 24 24">
                        <path stroke="none"
                            d="M16 8a6 6 0 016 6v7h-4v-7a2 2 0 00-2-2 2 2 0 00-2 2v7h-4v-7a6 6 0 016-6zM2 9h4v12H2z">
                        </path>
                        <circle cx="4" cy="4" r="2" stroke="none"></circle>
                    </svg>
                </a>
            </span>
        </div>


    </footer>

</body>
