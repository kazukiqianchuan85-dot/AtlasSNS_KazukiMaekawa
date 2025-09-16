<x-login-layout>
    <div class="p-4">
        <!-- 検索フォーム + 検索ワード -->
        <div class="flex items-center mb-4">
            <!-- 検索フォーム -->
            <form action="{{ route('user.search') }}" method="GET" class="inline-flex items-center">
                <input type="text" name="keyword" value="{{ $keyword ?? '' }}"
                      placeholder="ユーザー名"
                      class="border rounded px-2 py-1 w-64">

                <button type="submit" class="ml-2">
                    <img src="{{ asset('images/search.png') }}" alt="検索" style="width:32px; height:32px;">
                </button>
            </form>

            <!-- 検索ワード -->
            @if(!empty($keyword))
                <div class="ml-6 text-gray-700">
                   検索ワード：<span class="font-bold">{{ $keyword }}</span>
                </div>
            @endif
        </div>

        <!-- 検索結果 -->
        <div>
            @foreach ($users as $user)
                <div class="flex items-center justify-between border-b py-2">
                    <div class="flex items-center">
                        <img src="{{ asset('images/icon1.png') }}" alt="ユーザーアイコン"
                             class="rounded-full mr-2" style="width:40px; height:40px;">
                        <span>{{ $user->username }}</span>
                    </div>

                    <!-- フォロー/解除ボタンは既存処理と同じ -->
                    @if(auth()->user()->followings->contains($user->id))
                        <form action="{{ route('unfollow', $user->id) }}" method="POST">
                            @csrf
                            <button type="submit" class="px-4 py-1 bg-red-500 text-white rounded">フォロー解除</button>
                        </form>
                    @else
                        <form action="{{ route('follow', $user->id) }}" method="POST">
                            @csrf
                            <button type="submit" class="px-4 py-1 bg-blue-500 text-white rounded">フォローする</button>
                        </form>
                    @endif
                </div>
            @endforeach
        </div>
    </div>
</x-login-layout>
