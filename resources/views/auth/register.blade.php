<h1>회원가입</h1>

@if ($errors->any())
    <ul>
        @foreach ($errors->all() as $error)
            <li>{{ $error }}</li>
        @endforeach
    </ul>
@endif

<form method="POST" action="{{ route('simple.register') }}">
    @csrf
    <input name="name" placeholder="이름" value="{{ old('name') }}">
    <input name="email" placeholder="이메일" value="{{ old('email') }}">
    <input type="password" name="password" placeholder="비밀번호">
    <input type="password" name="password_confirmation" placeholder="비밀번호 확인">
    <button type="submit">가입</button>
</form>

<a href="{{ route('simple.login.form') }}">로그인</a>
