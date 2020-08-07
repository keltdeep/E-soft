@extends('layouts.app')


@section('content')
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
<div><a href={{$_SERVER["HTTP_HOST"]}}></a></div>
<div>Приглашение от {{$currentUser}}</div>
<div>Ваш логин {{$login}}</div>
<div>Ваш пароль {{$password}}</div>

@endsection
