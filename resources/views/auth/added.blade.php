<x-logout-layout>
  <div class="app-wrapper">
    <div>

      <div class="app-box">
        <p class="auth-username text-2xl font-bold">{{ $username }} さん</p>
        <p class="text-xl font-bold mt-1">ようこそ！AtlasSNSへ！</p>
        <p class="mt-2">ユーザー登録が完了しました。<br>早速ログインをしてみましょう！</p>

        <div class="mt-4">
          <a href="{{ url('login') }}" class="app-btn">ログイン画面へ</a>
        </div>
      </div>
    </div>
  </div>
</x-logout-layout>
