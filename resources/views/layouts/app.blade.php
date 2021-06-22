<!DOCTYPE html>
<html lang="ja">

<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link href="/css/app.css" rel="stylesheet">
  <meta name="csrf-token" content="{{ csrf_token() }}">
  <meta name="api-token" content="{{ session()->get('api_token') ?? '' }}">
</head>

  <body>
      <div id="app"> 
      <!-- Laravelは$errorsというグローバルなエラー情報を持っている。Vue.js全体にerrors propsにグローバルなエラー情報$errorsを設定 -->
      <!-- LaravelのBladeではAuth::user()という現在認証されているユーザーの情報の取得メソッドがグローバルに定義さている。 -->
        <app :errors="{{ $errors }}" :auth="{{ Auth::user() ?? '[]' }}"/> <!-- ログイン済みでない場合、値を取得できません。そこで値を取得できない場合は、空の配列を渡すようにします。 -->
      </div>
      
      <script src="https://use.fontawesome.com/e3ae05b8e6.js"></script>
      <script src="/js/app.js"></script>
  </body>
</html>
