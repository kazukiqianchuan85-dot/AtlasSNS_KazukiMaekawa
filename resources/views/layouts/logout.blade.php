<!DOCTYPE html>
<html lang="ja">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge" />
        <meta name="description" content="Atlas SNS ログイン・登録画面" />
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>Atlas SNS</title>

        {{-- ✅ ViteでTailwindとJSを読み込む --}}
        @vite(['resources/css/app.css', 'resources/js/app.js'])

        <!-- サイトアイコン（必要に応じて） -->
        <link rel="icon" href="画像URL" sizes="16x16" type="image/png" />
        <link rel="icon" href="画像URL" sizes="32x32" type="image/png" />
        <link rel="icon" href="画像URL" sizes="48x48" type="image/png" />
        <link rel="icon" href="画像URL" sizes="62x62" type="image/png" />
        <link rel="apple-touch-icon-precomposed" href="画像のURL" />
    </head>
    <body class="min-h-screen flex flex-col items-center justify-center bg-gradient-to-b from-blue-500 to-yellow-200">
        <header class="text-center mb-8">
            <h1 class="flex justify-center">
                <img src="{{ asset('images/atlas.png') }}" alt="Atlas Logo" class="w-48 h-auto">
            </h1>
            <p class="text-white text-5xl font-semibold mt-2">Social Network Service</p>
        </header>

        <main id="container" class="w-full max-w-md">
            {{ $slot }}
        </main>
    </body>
</html>
