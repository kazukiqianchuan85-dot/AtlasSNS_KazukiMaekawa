        <div id="head">
            <h1><a href="{{ url('/top') }}"><img src="images/atlas.png"></a></h1>

            <div class="nav-menu">
                <div class="user-info">
                    <p>〇〇さん</p>
                    <button class="accordion-header">
                        <span class="arrow">▼</span>
                    </button>
                </div>

                <div class="accordion-content">
                    <ul>
                        <li><a href="{{ url('/top') }}">ホーム</a></li>
                        <li><a href="{{ url('/profile') }}">プロフィール編集</a></li>
                        <li>
                            <a href="{{ url('/logout') }}"
                                onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                                ログアウト
                            </a>
                            <form id="logout-form" action="{{ url('/logout') }}" method="POST" style="display: none;">
                                @csrf
                            </form>
                        </li>
                    </ul>
                </div>
            </div>

        </div>
