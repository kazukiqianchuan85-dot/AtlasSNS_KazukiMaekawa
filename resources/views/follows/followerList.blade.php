<x-login-layout>
    <div id="follower-list" class="p-4">
        <!-- タイトル＋アイコンを横並び -->
        <div class="follower-header">
            <h2 class="page-title">フォロワーリスト</h2>

            <!-- フォロワーアイコン一覧 -->
            <div class="follower-icons">
                @foreach($followers as $follower)
                    <a href="{{ route('profile.show', $follower->id) }}" class="follower-icon-link">
                        <img src="{{ asset('images/' . $follower->icon_image) }}"
                             alt="{{ $follower->username }}のアイコン"
                             class="follower-icon-img">
                    </a>
                @endforeach
            </div>
        </div>

        <!-- フォロワーの投稿一覧 -->
        <div id="post-list">
            @forelse($posts as $post)
                <div class="post-card">
                    <div class="post-header">
                        <div class="post-user">
                            <a href="{{ route('profile.show', $post->user->id) }}">
                                <img src="{{ asset('images/' . $post->user->icon_image) }}"
                                     alt="ユーザーアイコン"
                                     class="post-user-icon">
                            </a>
                            <p class="post-user-name">{{ $post->user->username }}</p>
                        </div>
                        <small class="post-date">{{ $post->created_at->format('Y-m-d H:i') }}</small>
                    </div>
                    <p class="post-content">{{ $post->post }}</p>
                </div>
            @empty
                <p class="text-gray-500">フォロワーの投稿はまだありません。</p>
            @endforelse
        </div>
    </div>
</x-login-layout>
