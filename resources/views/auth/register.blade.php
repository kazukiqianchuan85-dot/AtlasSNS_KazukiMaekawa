<x-logout-layout>
  <div class="app-wrapper">
    <div>

      <div class="app-box">
            <div class="app-title"><p>新規ユーザー登録</p></div>
        {!! Form::open(['url' => 'register', 'method' => 'post']) !!}

          {{ Form::label('ユーザー名', null, ['class' => 'app-label']) }}
          {{ Form::text('username', null, ['class' => 'app-input']) }}
          @error('username')
            <div class="app-error">{{ $message }}</div>
          @enderror

          {{ Form::label('メールアドレス', null, ['class' => 'app-label']) }}
          {{ Form::email('email', null, ['class' => 'app-input']) }}
          @error('email')
            <div class="app-error">{{ $message }}</div>
          @enderror

          {{ Form::label('パスワード', null, ['class' => 'app-label']) }}
          {{ Form::password('password', ['class' => 'app-input']) }}
          @error('password')
            <div class="app-error">{{ $message }}</div>
          @enderror

          {{ Form::label('パスワード確認', null, ['class' => 'app-label']) }}
          {{ Form::password('password_confirmation', ['class' => 'app-input']) }}
          @error('password_confirmation')
            <div class="app-error">{{ $message }}</div>
          @enderror

          {{ Form::submit('新規登録', ['class' => 'app-btn float-right']) }}

        {!! Form::close() !!}

        <p class="app-link">
          <a href="{{ url('login') }}">ログイン画面へ戻る</a>
        </p>
      </div>
    </div>
  </div>
</x-logout-layout>
