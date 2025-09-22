<x-login-layout>
    <div class="p-4">
        <h2 class="text-xl font-bold mb-4">フォローリスト</h2>

        <!-- フォロー中ユーザーのアイコン一覧 -->
        <div class="flex flex-wrap gap-3 mb-6">
            @foreach($followings as $follow)
                @php
                // ユーザーごとに 1〜7 の範囲でアイコンを固定
                $iconNumber = ($follow->id % 7) + 1;
                @endphp
                <a href="{{ route('profile.show', $follow->id) }}">
                    <img src="{{ asset('images/icon' . $iconNumber . '.png') }}"
                         alt="{{ $follow->username }}のアイコン"
                         class="rounded-full border"
                         style="width:50px; height:50px;">
                </a>
            @endforeach
        </div>

        <!-- フォロー中ユーザーの投稿一覧 -->
        <div>
            @forelse($posts as $post)
                @php
                    $iconNumber = ($post->user->id % 7) + 1;
                @endphp
                <div class="border-b py-3">
                    <div class="flex items-center mb-1">
                        <img src="{{ asset('images/icon' . $iconNumber . '.png') }}"
                             alt="ユーザーアイコン"
                             class="rounded-full mr-2"
                             style="width:40px; height:40px;">
                        <span class="font-bold">{{ $post->user->username }}</span>
                        <span class="text-gray-500 text-sm ml-4">{{ $post->created_at }}</span>
                    </div>
                    <p>{{ $post->post }}</p>
                </div>
            @empty
                <p class="text-gray-500">フォロー中のユーザーの投稿はまだありません。</p>
            @endforelse
        </div>
    </div>
</x-login-layout>
