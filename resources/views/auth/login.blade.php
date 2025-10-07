<x-logout-layout>
    <!-- ログインボックス -->
    <div class="bg-black/30 backdrop-blur-md p-8 rounded-lg shadow-lg w-full max-w-sm text-center mx-auto">
        <h2 class="text-white text-xl mb-6 font-semibold">AtlasSNSへようこそ</h2>

        <form action="{{ route('login') }}" method="POST" class="space-y-4 text-left">
            @csrf
            <div>
                <label for="email" class="text-white block mb-1 text-sm">メールアドレス</label>
                <input
                    type="email"
                    name="email"
                    id="email"
                    class="w-full px-4 py-2 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-400"
                    required
                >
            </div>
            <div>
                <label for="password" class="text-white block mb-1 text-sm">パスワード</label>
                <input
                    type="password"
                    name="password"
                    id="password"
                    class="w-full px-4 py-2 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-400"
                    required
                >
            </div>
            <div class="text-right">
                <button
                    type="submit"
                    class="bg-red-500 text-white px-6 py-2 rounded-md hover:bg-red-600 transition"
                >
                    ログイン
                </button>
            </div>
        </form>

        <div class="mt-4">
            <a href="{{ route('register') }}" class="text-white underline text-sm">
                新規ユーザーの方はこちら
            </a>
        </div>
    </div>
</x-logout-layout>
