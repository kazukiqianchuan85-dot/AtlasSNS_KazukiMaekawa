<x-login-layout>
    <div class="p-8">

        {{-- 他人のプロフィール表示（プロフィールカード＋投稿一覧） --}}
        @if(Auth::id() !== $user->id)

            <!-- プロフィール情報カード -->
            <div class="profile-card">
                <div class="profile-header">
                    <div class="profile-icon">
                        <img src="{{ asset('images/' . ($user->icon_image ?? 'icon1.png')) }}"
                             alt="{{ $user->username }}のアイコン"
                             class="rounded-full">
                    </div>

                    <div class="profile-center">
                        <div class="profile-row">
                            <span class="profile-label">ユーザー名</span>
                            <span class="profile-value">{{ $user->username }}</span>
                        </div>
                        <div class="profile-row">
                            <span class="profile-label">自己紹介</span>
                            <span class="profile-value">{{ $user->bio ?? '自己紹介はまだありません。' }}</span>
                        </div>
                    </div>

                    <!-- フォローボタン -->
                    <div class="profile-follow">
                        @if(Auth::user()->followings->contains($user->id))
                            <form action="{{ route('unfollow', $user->id) }}" method="POST">
                                @csrf
                                <input type="hidden" name="redirect_to" value="{{ url()->current() }}">
                                <button type="submit" class="btn-unfollow">フォロー解除</button>
                            </form>
                        @else
                            <form action="{{ route('follow', $user->id) }}" method="POST">
                                @csrf
                                <input type="hidden" name="redirect_to" value="{{ url()->current() }}">
                                <button type="submit" class="btn-follow">フォローする</button>
                            </form>
                        @endif
                    </div>
                </div>
            </div>

            <!-- 投稿一覧 -->
            <div id="post-list">
                @foreach ($posts as $post)
                    <div class="post-card">
                        <div class="post-header">
                            <!-- ユーザーアイコン＋名前 -->
                            <div class="post-user">
                                <img src="{{ $post->user->icon_path }}" alt="ユーザーアイコン" class="post-user-icon">
                                <p class="post-user-name">{{ $post->user->username }}</p>
                            </div>

                            <!-- 日付 -->
                            <small class="post-date">{{ $post->created_at->format('Y-m-d H:i') }}</small>
                        </div>
                        <p class="post-content">{{ $post->post }}</p>
                    </div>
                @endforeach
            </div>

        @endif


        {{-- 自分のプロフィール表示（編集フォームのみ） --}}
        @if(Auth::id() === $user->id)
            <div class="profile-edit">
                <div class="profile-edit-icon">
                    <img src="{{ asset('images/' . ($user->icon_image ?? 'icon1.png')) }}"
                         alt="{{ $user->username }}のアイコン"
                         class="rounded-full border">
                </div>

                <form action="{{ route('profile.update') }}" method="POST" enctype="multipart/form-data" class="profile-edit-form">
                    @csrf

                    <div class="form-row">
                        <label>ユーザー名</label>
                        <input type="text" name="username" value="{{ old('username', $user->username) }}">
                    </div>

                    <div class="form-row">
                        <label>メールアドレス</label>
                        <input type="email" name="email" value="{{ old('email', $user->email) }}">
                    </div>

                    <div class="form-row">
                        <label>パスワード</label>
                        <input type="password" name="password" placeholder="変更する場合のみ入力">
                    </div>

                    <div class="form-row">
                        <label>パスワード確認</label>
                        <input type="password" name="password_confirmation" placeholder="確認のため再入力">
                    </div>

                    <div class="form-row">
                        <label>自己紹介</label>
                        <textarea name="bio" rows="2">{{ old('bio', $user->bio) }}</textarea>
                    </div>

                    <div class="form-row">
                        <label>アイコン画像</label>
                        <input type="file" name="image">
                    </div>

                    <div class="form-actions text-center mt-4">
                        <button type="submit" class="btn-update bg-red-500 text-white px-4 py-2 rounded">更新</button>
                    </div>
                </form>
            </div>
        @endif

    </div>
</x-login-layout>
