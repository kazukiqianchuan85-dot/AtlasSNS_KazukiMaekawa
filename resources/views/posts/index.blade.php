<x-login-layout>


    <!-- 投稿フォーム -->
    <div id="post-form" class="mb-4">
        <form action="{{ route('posts.store') }}" method="POST">
            @csrf
            <div class="post-box">
                <!-- ユーザーアイコン -->
                <div class="post-icon">
                    <img src="{{ Auth::user()->icon_path }}" alt="ユーザーアイコン"
                        class="rounded-full" style="width:40px; height:40px;">
                </div>

                <!-- 投稿内容入力 -->
                <textarea name="post" class="post-input" placeholder="投稿内容を入力してください。" maxlength="150"></textarea>

                <!-- 投稿ボタン -->
                <button type="submit" class="post-send-btn">
                    <img src="{{ asset('images/post.png') }}" alt="投稿" style="width:24px; height:24px;">
                </button>
            </div>
        </form>
        <!-- バリデーションエラー表示 -->
        @if ($errors->has('post'))
            <p style="color:red; margin-top:5px;">{{ $errors->first('post') }}</p>
        @endif
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

                <!-- 編集・削除ボタン -->
                @if ($post->user_id === Auth::id())
                    <div class="post-actions">
                        <button class="edit-btn" data-id="{{ $post->id }}" data-post="{{ e($post->post) }}">
                            <img src="{{ asset('images/edit.png') }}" alt="編集">
                        </button>
                        <button class="delete-btn" data-id="{{ $post->id }}">
                            <img src="{{ asset('images/trash.png') }}" alt="削除" class="trash-icon">
                        </button>
                    </div>
                @endif
            </div>
        @endforeach
    </div>


    <!-- 編集モーダル -->
    <div id="edit-modal" class="fixed inset-0 bg-black bg-opacity-50 hidden items-center justify-center">
        <div class="modal-inner">
            <form id="edit-form" method="POST">
            @csrf
            @method('PUT')

            <div class="textarea-wrapper">
                <textarea name="post" id="edit-input" maxlength="150"></textarea>
            </div>

            <img
                id="edit-submit-icon"
                src="{{ asset('images/edit.png') }}"
                alt="更新"
            >
            </form>
        </div>
    </div>


    <!-- 削除確認モーダル：画面上部に表示 -->
    <div id="delete-modal" class="hidden fixed top-0 left-0 w-full justify-center z-50">
        <div class="delete-box bg-white border border-gray-300 rounded-md shadow-lg w-[450px] text-center p-6">
            <p class="text-lg mb-6">この投稿を削除します。よろしいでしょうか？</p>
            <div class="flex justify-center gap-4">
            <button id="confirm-delete" class="px-6 py-2 bg-blue-600 text-white rounded hover:bg-blue-700">OK</button>
            <button id="cancel-delete" class="px-6 py-2 border border-gray-400 rounded hover:bg-gray-100">キャンセル</button>
            </div>
        </div>
    </div>

    <form id="delete-form" method="POST" action="" class="hidden">
    @csrf
    @method('DELETE')
    </form>



    <!-- 編集JS -->
    <script>
    document.addEventListener('DOMContentLoaded', function () {
        // ======== 編集モーダル関連 ========
        const editModal = document.getElementById('edit-modal');
        const editInput = document.getElementById('edit-input');
        const editForm = document.getElementById('edit-form');
        const editSubmitIcon = document.getElementById('edit-submit-icon');

        // 編集ボタンを押したとき
        document.body.addEventListener('click', function (e) {
            const btn = e.target.closest('.edit-btn');
            if (!btn) return;

            const postId = btn.dataset.id;
            const postContent = btn.dataset.post;

            editForm.action = `/posts/${postId}`;
            editInput.value = postContent;
            editModal.classList.remove('hidden');
            editModal.classList.add('flex');
            document.body.classList.add('modal-open'); // 背景固定
        });

        // モーダル背景クリックで閉じる
        editModal.addEventListener('click', function (e) {
            if (e.target === editModal) {
                editModal.classList.add('hidden');
                editModal.classList.remove('flex');
                document.body.classList.remove('modal-open');
            }
        });

        // 画像クリックで送信
        editSubmitIcon.addEventListener('click', async function () {
            const response = await fetch(editForm.action, {
                method: 'POST',
                body: new FormData(editForm),
            });
            if (response.ok) {
                location.reload();
            }
        });

        // hover切替
        editSubmitIcon.addEventListener('mouseenter', () => {
            editSubmitIcon.src = "{{ asset('images/edit_h.png') }}";
        });
        editSubmitIcon.addEventListener('mouseleave', () => {
            editSubmitIcon.src = "{{ asset('images/edit.png') }}";
        });

        // ======== 削除モーダル関連 ========
        const deleteButtons = document.querySelectorAll('.delete-btn');
        const deleteModal = document.getElementById('delete-modal');
        const cancelDelete = document.getElementById('cancel-delete');
        const confirmDelete = document.getElementById('confirm-delete');
        const deleteForm   = document.getElementById('delete-form');
        const deleteBox    = document.querySelector('.delete-box');
        let currentPostId = null;

        // モーダル表示
        deleteButtons.forEach(btn => {
            btn.addEventListener('click', () => {
                currentPostId = btn.dataset.id;
                deleteModal.classList.remove('hidden');
                deleteModal.classList.add('flex');
                document.body.classList.add('modal-open');
            });
        });

        // 外クリックは無効化（閉じない）
        deleteModal.addEventListener('click', (e) => {
            if (!deleteBox.contains(e.target)) {
                e.preventDefault();
            }
        });

        // OKボタン
        confirmDelete.addEventListener('click', (e) => {
            e.stopPropagation();
            if (!currentPostId) return;
            deleteForm.action = `/posts/${currentPostId}`;
            deleteForm.submit();
            document.body.classList.remove('modal-open');
        });

        // キャンセルボタン
        cancelDelete.addEventListener('click', (e) => {
            e.stopPropagation();
            deleteModal.classList.add('hidden');
            deleteModal.classList.remove('flex');
            document.body.classList.remove('modal-open');
            currentPostId = null;
        });
    });
    </script>

</x-login-layout>
