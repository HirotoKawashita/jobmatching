<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="{{ asset('/css/app.scss')}}">
    <script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>
    <title>job-matching</title>
</head>
<body>
    <header>
        <div class="header common">
            <h1><a href=""><img src="{{ asset('images/hitLogo.svg') }}" alt="HITスクールのロゴ"></a></h1>
            <form class="headerSearch" action="" method="get">
                <input class="search" type="search" name="ageSearch" placeholder="キーワード">
                <input class="submit" type="submit" value="検索" name="submit">
                <p class="searchDetail">条件詳細▲</p>
            </form>
            <div class="headerLogin">
                <form method="POST" action="{{ route('logout') }}">
                    <p><a class="user-name" href="">ユーザー:　<span>{{ Auth::user() ? Auth::user()->name : ''}}</span></a></p>
                    @csrf
                    <p><button class="sign-out" type="submit">サインアウト</button></p>
                </form>
            </div>
        </div>
    </header>
    <div class="globalNav menu_nav">
        <nav>
            <ul class="common">
                <li><a href="/notifications">Top</a></li>
                <li><a href="/students">生徒情報</a></li>
                <li><a href="/scouts">スカウト中</a></li>
                <li><a href="/jobs">求人管理</a></li>
                <li><a href="/favorites">お気に入り</a></li>
                <li><a href="/browsing_histories">閲覧履歴</a></li>
                <li class="has-child"><a href="">設定</a>
                    <ul class="menuDrop">
                        <li><a href="{{ route('corporations.view', ['id' => Auth::user()->id]) }}">企業詳細</a></li>
                        <li><a href="{{route('corporations.edit', ['id' => Auth::user()->id])}}">企業更新</a></li>
                        <li><a href="">パスワード再設定</a></li>
                    </ul>
                </li>
                <li><a href="/helps">ヘルプ</a></li>
            </ul>
        </nav>
    </div>
    <main>
@yield('content')
   </main>
</body>
</html>
