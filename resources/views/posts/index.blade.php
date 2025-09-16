<x-login-layout>


  <!-- 投稿フォーム -->
  <div id="post-form" class="mb-4">
      <form action="{{ route('posts.store') }}" method="POST">
          @csrf
          <div class="flex items-center">
              <!-- ユーザーアイコン -->
              <div class="mr-2">
                  <img src="{{ asset('images/icon1.png') }}" alt="ユーザーアイコン"
                       class="rounded-full" style="width:40px; height:40px;">
              </div>

              <!-- 投稿内容入力 -->
              <div class="flex-1">
                  <input type="text" name="post" class="w-full border rounded p-2"
                         placeholder="投稿内容を入力してください。" maxlength="150">
              </div>

              <!-- 投稿ボタン -->
              <div class="ml-2">
                  <button type="submit">
                      <img src="{{ asset('images/post.png') }}" alt="投稿" style="width:32px; height:32px;">
                  </button>
              </div>
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
        <div class="border-b py-4 relative">
            <!-- ユーザー情報と投稿内容 -->
            <div class="flex items-start">
                <!-- ユーザーアイコン -->
                <div class="mr-2">
                    <img src="{{ asset('images/icon1.png') }}" alt="ユーザーアイコン"
                         class="rounded-full" style="width:40px; height:40px;">
                </div>

                <div class="flex-1">
                    <p class="font-bold">{{ $post->user->name }}</p>
                    <p class="mb-2">{{ $post->post }}</p>
                    <small class="text-gray-500">{{ $post->created_at->format('Y-m-d H:i') }}</small>
                </div>
            </div>

            <!-- 自分の投稿なら編集アイコンを表示 -->
            @if ($post->user_id === Auth::id())
                <div class="absolute bottom-2 right-10">
                    <!-- 編集ボタン -->
                    <button
                        class="edit-btn"
                        data-id="{{ $post->id }}"
                        data-post="{{ e($post->post) }}">
                        <img src="{{ asset('images/edit.png') }}" alt="編集" style="width:24px; height:24px;">
                    </button>

                    <!-- 削除ボタン -->
                    <button
                        class="delete-btn"
                        data-id="{{ $post->id }}">
                        <img src="{{ asset('images/trash.png') }}"
                            alt="削除"
                            class="trash-icon"
                            style="width:24px; height:24px;">
                    </button>
                </div>
            @endif
        </div>
    @endforeach
  </div>


  <!-- 編集モーダル -->
  <div id="edit-modal" class="fixed inset-0 bg-black bg-opacity-50 hidden flex items-center justify-center">
      <div class="bg-white p-6 rounded shadow-md w-96">
          <h2 class="text-lg font-bold mb-4">投稿を編集</h2>
          <form id="edit-form" method="POST">
              @csrf
              @method('PUT')
              <input type="hidden" name="id" id="edit-id">
              <input type="text" name="post" id="edit-input"
                     class="w-full border rounded p-2 mb-4" maxlength="150">

              <div class="flex justify-end">
                  <button type="button" id="cancel-edit" class="mr-2 px-4 py-2 bg-gray-300 rounded">キャンセル</button>
                  <button type="submit" class="px-4 py-2 bg-blue-500 text-white rounded">更新</button>
              </div>
          </form>
      </div>
  </div>

  <!-- 削除確認モーダル -->
  <div id="delete-modal" class="fixed inset-0 bg-black bg-opacity-50 hidden flex items-center justify-center">
        <div class="bg-white p-6 rounded shadow-md w-96">
            <h2 class="text-lg font-bold mb-4">この投稿を削除します。よろしいですか？</h2>
            <form id="delete-form" method="POST">
                @csrf
                @method('DELETE')
                <div class="flex justify-end">
                    <button type="button" id="cancel-delete" class="mr-2 px-4 py-2 bg-gray-300 rounded">キャンセル</button>
                    <button type="submit" class="px-4 py-2 bg-red-500 text-white rounded">削除</button>
                </div>
            </form>
        </div>
  </div>

    <!-- 編集JS -->
  <script>
    document.addEventListener('DOMContentLoaded', function () {
        const modal = document.getElementById('edit-modal');
        const editInput = document.getElementById('edit-input');
        const editForm = document.getElementById('edit-form');
        const cancelBtn = document.getElementById('cancel-edit');

        // HTMLエンティティをデコード（&amp; 等を戻す）
        function decodeHtml(html) {
            const txt = document.createElement('textarea');
            txt.innerHTML = html;
            return txt.value;
        }

        // イベントデリゲーションで edit-btn を捕まえる（動的な要素でもOK）
        document.body.addEventListener('click', function (e) {
            const btn = e.target.closest('.edit-btn');
            if (!btn) return;

            const postId = btn.dataset.id;
            let postContent = btn.dataset.post || '';

            // デコードして textarea/input に入れる
            postContent = decodeHtml(postContent);

            // フォームの action を設定（PUT /posts/{id} を想定）
            editForm.action = `/posts/${postId}`;

            // 初期値セット
            editInput.value = postContent;

            // モーダルを表示
            modal.classList.remove('hidden');
            modal.classList.add('flex');
        });

        // キャンセルで閉じる
        if (cancelBtn) {
            cancelBtn.addEventListener('click', function () {
                modal.classList.add('hidden');
                modal.classList.remove('flex');
                editForm.action = '';
                editInput.value = '';
            });
        }

        // モーダル背景クリックで閉じる（任意）
        modal.addEventListener('click', function (e) {
            if (e.target === modal) {
                modal.classList.add('hidden');
                modal.classList.remove('flex');
                editForm.action = '';
                editInput.value = '';
            }
        });
    });
  </script>

    <!-- 削除JS -->
  <script>
    document.addEventListener('DOMContentLoaded', function () {
        // ===== 削除処理 =====
        const deleteButtons = document.querySelectorAll('.delete-btn');
        const deleteModal = document.getElementById('delete-modal');
        const deleteForm = document.getElementById('delete-form');
        const cancelDelete = document.getElementById('cancel-delete');

        deleteButtons.forEach(button => {
            button.addEventListener('click', function () {
                const postId = this.dataset.id;
                deleteForm.action = `/posts/${postId}`;
                deleteModal.classList.remove('hidden');
                deleteModal.classList.add('flex');
            });
        });

        // キャンセルで閉じる
        cancelDelete.addEventListener('click', function () {
            deleteModal.classList.add('hidden');
            deleteModal.classList.remove('flex');
            deleteForm.action = '';
        });

        // 背景クリックで閉じる
        deleteModal.addEventListener('click', function (e) {
            if (e.target === deleteModal) {
                deleteModal.classList.add('hidden');
                deleteModal.classList.remove('flex');
                deleteForm.action = '';
            }
        });

        // ===== ゴミ箱アイコンのホバー =====
        const trashIcons = document.querySelectorAll('.trash-icon');
        trashIcons.forEach(icon => {
            icon.addEventListener('mouseenter', () => {
                icon.src = "{{ asset('images/trash-h.png') }}";
            });
            icon.addEventListener('mouseleave', () => {
                icon.src = "{{ asset('images/trash.png') }}";
            });
        });
    });
  </script>



</x-login-layout>
