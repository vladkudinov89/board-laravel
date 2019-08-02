<!doctype html>
<html lang="{{ app()->getLocale() }}">
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1">

  <title>{{ config('app.name') }}</title>

  <!-- Fonts -->
  <link href="https://fonts.googleapis.com/css?family=Nunito:200,600" rel="stylesheet" type="text/css">

  <style>
    html, body {
      background-color: #fff;
      background-image: radial-gradient(circle, #fff, #fff, #ddd);
      color: #636b6f;
      font-family: 'Nunito', sans-serif;
      font-weight: 200;
      height: 100vh;
      margin: 0;
    }

    .full-height {
      height: 100vh;
    }

    .flex-center {
      align-items: center;
      display: flex;
      justify-content: center;
    }

    .position-ref {
      position: relative;
    }

    .top-right {
      position: absolute;
      right: 10px;
      top: 18px;
    }

    .content {
      text-align: center;
    }

    .title {
      font-size: 84px;
    }

    .users {
      font-size: 14px;
    }

    .users-list {
      font-size: 12px;
      list-style: none;
      padding: 0;
    }

    .users-list li {
      display: inline-block;
      padding-left: 10px;
    }

    .links > a {
      color: #252e37;
      padding: 0 25px;
      font-size: 12px;
      font-weight: 600;
      letter-spacing: .1rem;
      text-decoration: none;
      text-transform: uppercase;
    }
  </style>
  <!-- Styles -->
</head>
<body>
<div class="flex-center position-ref full-height">
  <div class="top-right links">
    @if (\Illuminate\Support\Facades\Route::has('login'))
      <a href="{{ route('login') }}">Log in</a>
    @endif
  </div>
  <div class="content">
    <div class="title">
      <img src="{{ asset('img/laravel-in-docker.png') }}" alt="Laravel in docker" width="400">
      <p class="users">
        Users:
        <ul class="users-list">
          @foreach($users as $user)
            @if($user instanceof \App\Models\User)
              <li>{{ $user->name }}</li>
            @endif
          @endforeach
        </ul>
      </p>
    </div>
  </div>
</div>
</body>
</html>
