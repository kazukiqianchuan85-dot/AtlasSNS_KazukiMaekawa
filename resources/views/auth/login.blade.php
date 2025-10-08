<x-logout-layout>
  <div class="app-wrapper">
    <div>

      <div class="app-box">
            <div class="app-title"><p>AtlasSNSへようこそ</p></div>
        {!! Form::open(['url' => 'login', 'method' => 'post']) !!}

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

          {{ Form::submit('ログイン', ['class' => 'app-btn']) }}

        {!! Form::close() !!}

        <p class="app-link">
          <a href="{{ url('register') }}">新規ユーザー登録はこちら</a>
        </p>
      </div>
    </div>
  </div>
</x-logout-layout>
