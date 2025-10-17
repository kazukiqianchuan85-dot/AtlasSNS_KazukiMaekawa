        <div id="head">
            <h1><a href="{{ url('/top') }}"><img src="images/atlas.png"></a></h1>

            <div class="nav-menu">
                <div class="user-info">
                    <p>{{ Auth::user()->username }}さん</p>
                    <button class="accordion-header">
                        <span class="arrow">▼</span>
                    </button>
                    <img src="{{ Auth::user()->icon_path }}"
                        alt="ユーザーアイコン"
                        class="user-icon">
                </div>

                <div class="accordion-content">
                    <ul>
                        <li><a href="{{ url('/top') }}">HOME</a></li>
                        <li><a href="{{ url('/profile') }}">プロフィール編集</a></li>
                        <li><a href="{{ url('/logout') }}">ログアウト</a></li>
                    </ul>
                </div>
            </div>

        </div>
