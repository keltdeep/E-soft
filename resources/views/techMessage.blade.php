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
<div>Сообщение от пользователя {{$login}}</div>
<div>{{$message}}</div>
@endsection
