<x-login-layout>
    <div class="p-4">
        <h2 class="text-xl font-bold mb-4">{{ $user->username }} のプロフィール</h2>

        <!-- アイコン -->
        <img src="{{ asset('images/' . ($user->icon_image ?? 'icon1.png')) }}"
             alt="{{ $user->username }}のアイコン"
             class="rounded-full mb-4"
             style="width:80px; height:80px;">

        <!-- プロフィール文 -->
        @if(!empty($user->bio))
            <p class="mb-6">{{ $user->bio }}</p>
        @endif

        <!-- 投稿一覧 -->
        <h3 class="text-lg font-semibold mb-3">投稿一覧</h3>
        <div class="space-y-4">
            @foreach($posts as $post)
                <div class="border rounded p-3">
                    <div class="flex items-center mb-2">
                        <img src="{{ asset('images/' . ($post->user->icon_image ?? 'icon1.png')) }}"
                             alt="{{ $post->user->username }}のアイコン"
                             class="rounded-full mr-2"
                             style="width:40px; height:40px;">
                        <div>
                            <p class="font-bold">{{ $post->user->username }}</p>
                            <small class="text-gray-500">{{ $post->created_at->format('Y-m-d H:i') }}</small>
                        </div>
                    </div>
                    <p>{{ $post->post }}</p>
                </div>
            @endforeach
        </div>
    </div>
</x-login-layout>
