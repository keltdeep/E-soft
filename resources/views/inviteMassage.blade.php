<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Massage</title>
</head>
<body>
@csrf

@if ($errors->any())
    <div class="alert alert-danger">
        <ul>
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div><br />
@endif
<div>Приглашаем вас принять участие в игре Спартак!</div>
<div>Ссылка {{$server}}></div>
<div>Приглашение от {{$currentUser}}</div>
<div>Ваш логин {{$login}}</div>
<div>Ваш пароль {{$password}}</div>

</body>
</html>
