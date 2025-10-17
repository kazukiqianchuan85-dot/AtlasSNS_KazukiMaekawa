<x-login-layout>
    <div id="user-search" class="p-6">
        <!--検索フォーム -->
        <div class="search-header">
            <form action="{{ route('user.search') }}" method="GET" class="search-form">
                <input type="text" name="keyword" value="{{ $keyword ?? '' }}" placeholder="ユーザー名" class="search-input">
                <button type="submit" class="search-btn">
                    <img src="{{ asset('images/search.png') }}" alt="検索" class="search-icon">
                </button>
            </form>

            @if(!empty($keyword))
                <div class="search-keyword">
                    検索ワード：<span class="font-bold">{{ $keyword }}</span>
                </div>
            @endif
        </div>

        <!--検索結果リスト -->
        <div class="user-list">
            @foreach ($users as $user)
                <div class="user-card">
                    <div class="user-info">
                        @php
                            $iconNumber = ($user->id % 7) + 1;
                        @endphp
                        <a href="{{ route('profile.show', $user->id) }}">
                            <img src="{{ asset('images/icon' . $iconNumber . '.png') }}" alt="{{ $user->username }}のアイコン" class="user-icon">
                        </a>
                        <span class="user-name">{{ $user->username }}</span>
                    </div>

                    <!-- フォローボタン -->
                    <div class="user-action">
                        @if(auth()->user()->followings->contains($user->id))
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
            @endforeach
        </div>
    </div>
</x-login-layout>
