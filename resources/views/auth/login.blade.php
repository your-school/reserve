@extends('layouts.layout')

@section('home-link')
@endsection

@section('modal-home-link')
@endsection


@section('content')
    <main class="text-gray-600 body-font">
        <form name="loginForm" method="POST" action="{{ route('login') }}">
            @csrf
            <div class="container px-10 py-10 md:py-20 mx-auto flex flex-wrap justify-center md:items-center">

                <div class="lg:w-2/6 md:w-1/2 bg-gray-100 rounded-lg p-8 flex flex-col md:mx-auto w-full mt-10 md:mt-0">
                    <div class="text-center">
                        <h1 class="block text-2xl font-bold text-gray-800 dark:text-black">管理者ログイン</h1>
                        <p class="mt-2 text-sm text-gray-600 dark:text-gray-400">
                        </p>
                    </div>


                    <div class="flex items-center border-2 py-1 px-3 rounded-md mt-3 mb-4 bg-white">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-gray-400" fill="none"
                            viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M16 12a4 4 0 10-8 0 4 4 0 008 0zm0 0v1.5a2.5 2.5 0 005 0V12a9 9 0 10-9 9m4.5-1.206a8.959 8.959 0 01-4.5 1.207" />
                        </svg>
                        <input
                            class="w-full pl-2 outline-none border-none focus:outline-none focus:border-none focus:ring-0"
                            type="email" id="email" name="email" value="{{ old('email') }}" autocomplete="email"
                            required aria-describedby="email-error" placeholder="メールアドレス" />
                        @error('email')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>

                    <div class="flex items-center border-2 py-1 px-3 rounded-md mt-3 mb-4 bg-white">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-gray-400" viewBox="0 0 20 20"
                            fill="currentColor">
                            <path fill-rule="evenodd"
                                d="M5 9V7a5 5 0 0110 0v2a2 2 0 012 2v5a2 2 0 01-2 2H5a2 2 0 01-2-2v-5a2 2 0 012-2zm8-2v2H7V7a3 3 0 016 0z"
                                clip-rule="evenodd" />
                        </svg>
                        <input
                            class="w-full pl-2 outline-none border-none focus:outline-none focus:border-none focus:ring-0"
                            type="password" id="password" name="password" required autocomplete="new-password" required
                            aria-describedby="password-error" placeholder="パスワード" />
                        @error('password')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>
                    <p class="hidden text-xs text-red-600 mt-2" id="password-error">8+ characters required
                    </p>

                    <div class="ml-2 m-3 text-gray-900">
                        <input type="checkbox" name="remember" id="remember" {{ old('remember') ? 'checked' : '' }}>

                        <label for="remember">
                            ログイン状態を維持する
                        </label>
                    </div>

                    <button
                        class="m-1 text-white bg-red-500 border-0 py-2 px-8 focus:outline-none hover:bg-red-600 rounded text-lg">ログイン</button>

                    <div class="underline mt-4 text-blue-600 hover:text-blue-800">
                        @if (Route::has('password.request'))
                            <a href="{{ route('password.request') }}">
                                パスワードを忘れた場合
                            </a>
                        @endif
                    </div>

                    <button
                        class="mx-1 mb-1 mt-4 text-white bg-blue-500 border-0 py-2 px-8 focus:outline-none hover:bg-blue-600 rounded text-lg"
                        onclick="developerLogin()">開発者ログイン</button>

                </div>
            </div>

        </form>

    </main>
    <script>
        function developerLogin() {
            document.getElementById('email').value = 'test@test.com'; // 開発者のEメール
            document.getElementById('password').value = 'testtest'; // 開発者のパスワード
            document.getElementById('login-form').submit(); // フォーム送信
        }
    </script>
@endsection
