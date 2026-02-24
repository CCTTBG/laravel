<h1>로그인</h1>

@if ($errors->any())
    <ul>
        @foreach ($errors->all() as $error)
            <li>{{ $error }}</li>
        @endforeach
    </ul>
@endif

<form method="POST" action="{{ route('simple.login') }}">
    @csrf
    <input name="email" placeholder="이메일" value="{{ old('email') }}">
    <input type="password" name="password" placeholder="비밀번호">
    <button type="submit">로그인</button>
</form>

<a href="{{ route('simple.register.form') }}">회원가입</a>
