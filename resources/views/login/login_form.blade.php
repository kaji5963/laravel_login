<!DOCTYPE html>
<html lang="ja">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>ログインフォーム</title>
    {{-- scripts  --}}
    <script src="{{ asset('js/app/js') }}" defer></script>
    {{-- styles  --}}
    <link rel="stylesheet" href="{{ asset('css/app/css') }}">
</head>

<body>
    <form method="POST" action="{{ route('login') }}">
        @csrf
        <h1 class="h3 mb-3 fw-normal">ログインフォーム</h1>
        @if ($errors->any())
            <div class="alert alert-danger">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <x-alert type="danger" :session="session('login_error')" />

        <x-alert type="danger" :session="session('logout')" />

        <div class="form-floating">
            <input type="email" class="form-control" id="floatingInput" name="email" placeholder="name@example.com">
            <label for="floatingInput"></label>
        </div>
        <div class="form-floating">
            <input type="password" class="form-control" id="floatingPassword" name="password" placeholder="Password">
            <label for="floatingPassword"></label>
        </div>
        <button class="w-100 btn btn-lg btn-primary" type="submit">ログイン</button>
    </form>
</body>

</html>
