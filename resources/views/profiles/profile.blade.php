<x-login-layout>
    <div class="p-4">
        <!-- プロフィール情報 -->
        <div class="flex items-center mb-6">
            <img src="{{ asset('images/' . ($user->icon_image ?? 'icon1.png')) }}"
                 alt="{{ $user->username }}のアイコン"
                 class="rounded-full mr-4"
                 style="width:80px; height:80px;">
            <div>
                <h2 class="text-xl font-bold">{{ $user->username }}</h2>
                <p class="text-gray-600">{{ $user->bio ?? '自己紹介はまだありません。' }}</p>
                <!-- フォロー/フォロー解除ボタン -->
                @if(Auth::id() !== $user->id)
                    @if(Auth::user()->followings->contains($user->id))
                        <!-- フォロー解除 -->
                        <form action="{{ route('unfollow', $user->id) }}" method="POST" class="inline">
                            @csrf
                            <input type="hidden" name="redirect_to" value="{{ url()->current() }}">
                            <button type="submit" class="bg-red-500 text-white px-3 py-1 rounded">
                                フォロー解除
                            </button>
                        </form>
                    @else
                        <!-- フォローする -->
                        <form action="{{ route('follow', $user->id) }}" method="POST" class="inline">
                            @csrf
                            <input type="hidden" name="redirect_to" value="{{ url()->current() }}">
                            <button type="submit" class="bg-blue-500 text-white px-3 py-1 rounded">
                                フォローする
                            </button>
                        </form>
                    @endif
                @endif
            </div>
        </div>

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
