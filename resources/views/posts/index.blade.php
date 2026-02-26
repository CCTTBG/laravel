<!DOCTYPE html>
<html lang="ko">
<head>
    <meta charset="UTF-8">
    <title>게시판 목록</title>
</head>
<body>
<h1>게시판 목록</h1>
<div>
@if(auth()->check())
    <p>{{ auth()->user()->name }} 님 로그인중 {{auth()->user()->rank->name}} </p>
    <form method="POST" action="{{ route('simple.logout') }}">
        @csrf
        <button type="submit">로그아웃</button>
    </form>
    <div  style="margin-top: 50px;">
        <a href="#" id="openCreate" class="createPopUp">글쓰기</a>
    </div>

    @else
    <a href="/login">로그인</a>
@endif

</div>


<hr>

@if($posts->isEmpty())
    <p>게시글이 없습니다.</p>
@else
    <table border="1" cellpadding="8">
        <thead>
        <tr>
            <th>ID</th>
            <th>작성자(name)</th>
            <th>내용(comment)</th>
            <th>작성일</th>
            <th>수정</th>
            <th>삭제</th>
        </tr>
        </thead>
        <tbody>
        @foreach($posts as $post)
            <tr>
                <td>{{ $post->id }}</td>
                <td>{{ $post->name }}</td>
                <td>
                    @if($post->is_notice)
                        <strong style="color:red;">[공지]</strong>
                    @endif
                    {{ $post->comment }}
                </td>
                <td>{{ $post->created_at }}</td>
                <td><a href="#"
                       class="openEdit"
                       data-id="{{ $post->id }}"
                       data-name="{{ $post->name }}"
                       data-comment="{{ $post->comment }}">수정</a>
                </td>
                <td>
                    <form action="{{ route('posts.destroy',$post->id) }}" method="post">
                        @csrf
                        @method('DELETE')
                        <button type="submit">삭제</button>
                    </form>
            </tr>
        @endforeach
        </tbody>
    </table>
@endif
@if(auth()->check())
<div class="popUp" id="postPopup">
    <form id="postForm" method="POST">
        @csrf
        <div style="margin-top:10px;">
            <label>
                <input type="checkbox" name="is_notice" value="1">
                공지로 등록
            </label>
        </div>
        <input type="hidden" name="_method" id="methodSpoof" value="PUT" disabled>

        <table>
            <thead>
            <tr>
                <th>작성자</th>
                <th>내용</th>
            </tr>
            </thead>
            <tbody>
            <tr>
                <td><input id="inputName" value="{{ auth()->user()->name }}" readonly></td>
                <td><input name="comment" id="inputComment"></td>
            </tr>
            </tbody>
        </table>

        <div style="margin-top:10px;">
            <p>노출 그룹 선택(복수 가능)</p>
            @foreach($groups as $group)
                <label style="display:inline-block; margin-right:10px;">
                    <input type="checkbox" name="groups[]" value="{{ $group->id }}">
                    {{ $group->name }}
                </label>
            @endforeach
        </div>
        <button type="submit" id="submitBtn">등록</button>
        <button type="button" id="closePopup">닫기</button>
    </form>
</div>
@endif

</body>

<script>
        document.addEventListener("DOMContentLoaded", () => {
        const popup = document.getElementById("postPopup");
        const form = document.getElementById("postForm");
        const methodSpoof = document.getElementById("methodSpoof");

        const inputName = document.getElementById("inputName");
        const inputComment = document.getElementById("inputComment");
        const submitBtn = document.getElementById("submitBtn");

        const openCreate = document.getElementById("openCreate");
        const closeBtn = document.getElementById("closePopup");

        // 등록 모드
        openCreate.addEventListener("click", (e) => {
        e.preventDefault();

        form.action = "/posts";
        form.method = "POST";
        methodSpoof.disabled = true;      // PUT 끄기

        inputComment.value = "";
        submitBtn.textContent = "등록";

        popup.classList.add("active");
    });

        // 수정 모드 (여러개)
        document.querySelectorAll(".openEdit").forEach(btn => {
        btn.addEventListener("click", (e) => {
        e.preventDefault();

        const id = btn.dataset.id;
        form.action = `/posts/${id}`;   // posts.update
        form.method = "POST";
        methodSpoof.disabled = false;   // PUT 켜기

        inputName.value = btn.dataset.name ?? "";
        inputComment.value = btn.dataset.comment ?? "";
        submitBtn.textContent = "수정";

        popup.classList.add("active");
    });
    });

        // 닫기
        closeBtn.addEventListener("click", () => {
        popup.classList.remove("active");
    });
    });
</script>
<style>
    .popUp {
        display: none;
        position: fixed;
        top: 50%;
        left: 50%;
        transform: translate(-50%, -50%);

        background: white;
        padding: 20px;
        border: 2px solid #333;
        box-shadow: 0 5px 20px rgba(0,0,0,0.3);
        z-index: 1000;
    }

    .popUp.active {
        display: block; /* 클릭 시 보이기 */
    }

    .createPopUp {
        cursor: pointer;
        padding: 10px 15px;
        background: #4CAF50;
        text-decoration: none;
    }
</style>
</html>
