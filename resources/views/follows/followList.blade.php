<x-login-layout>
    <div id="follow-list" class="p-4">
        <!-- タイトル＋アイコン横並び -->
        <div class="follow-header">
            <h2 class="page-title">フォローリスト</h2>

            <div class="follow-icons">
                @foreach($followings as $follow)
                    <a href="{{ route('profile.show', $follow->id) }}" class="follow-icon-link">
                        <img src="{{ asset('images/' . $follow->icon_image) }}"
                             alt="{{ $follow->username }}のアイコン"
                             class="follow-icon-img">
                    </a>
                @endforeach
            </div>
        </div>

        <!-- フォロー中ユーザーの投稿一覧 -->
        <div id="post-list">
            @forelse($posts as $post)
                <div class="post-card">
                    <div class="post-header">
                        <div class="post-user">
                            <img src="{{ asset('images/' . $post->user->icon_image) }}"
                                 alt="ユーザーアイコン"
                                 class="post-user-icon">
                            <p class="post-user-name">{{ $post->user->username }}</p>
                        </div>
                        <small class="post-date">{{ $post->created_at->format('Y-m-d H:i') }}</small>
                    </div>
                    <p class="post-content">{{ $post->post }}</p>
                </div>
            @empty
                <p class="no-follow-posts">フォロー中のユーザーの投稿はまだありません。</p>
            @endforelse
        </div>
    </div>
</x-login-layout>
