<x-login-layout>
    <div class="p-4">
        <h2 class="text-xl font-bold mb-4">フォロワーリスト</h2>

        <!-- フォロワーのアイコン一覧 -->
        <div class="flex flex-wrap gap-3 mb-6">
            @foreach($followers as $follower)
                <a href="{{ route('profile.show', $follower->id) }}">
                    <img src="{{ asset('images/icon' . (($follower->id % 7) + 1) . '.png') }}"
                         alt="{{ $follower->username }}のアイコン"
                         class="rounded-full border"
                         style="width:50px; height:50px;">
                </a>
            @endforeach
        </div>

        <!-- フォロワーの投稿一覧 -->
        <div>
            @foreach($posts as $post)
                <div class="border-b py-3">
                    <div class="flex items-center mb-1">
                        <a href="{{ route('profile.show', $post->user->id) }}">
                            <img src="{{ asset('images/icon' . (($post->user->id % 7) + 1) . '.png') }}"
                                 alt="{{ $post->user->username }}のアイコン"
                                 class="rounded-full mr-2"
                                 style="width:40px; height:40px;">
                        </a>
                        <span class="font-bold">{{ $post->user->username }}</span>
                        <span class="text-gray-500 text-sm ml-4">{{ $post->created_at }}</span>
                    </div>
                    <p>{{ $post->post }}</p>
                </div>
            @endforeach
        </div>
    </div>
</x-login-layout>
