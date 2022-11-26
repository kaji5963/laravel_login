<!DOCTYPE html>
<html lang="ja">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
</head>

<body>
    <div class="container">
        <div>
            <x-alert type="success" :session="session('login_success')" />

            <h3>プロフィール</h3>
            <ul>
                <li>名前：{{ Auth::user()->name }}</li>
                <li>メールアドレス：{{ Auth::user()->email }}</li>
            </ul>
            <form action="{{ route('logout') }}" method="POST">
                @csrf
                <button>ログアウト</button>
            </form>
        </div>
    </div>
</body>

</html>
