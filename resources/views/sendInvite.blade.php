@extends('layouts.app')


@section('content')
    <div class="container">
        <h5 class="row justify-content-center">Вы можете пригласить вашего друга в игру :)</h5>

        <div class="row justify-content-center">
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

<form method = POST action="/sendInvite">
    @csrf
    {{csrf_field()}}
    <label for="email">E-mail</label>
        <input type="email" id="email" name="email">

    <input type="hidden" value="{!! csrf_token() !!}" name="_token">

    <div>
        <button type="submit">Отправить приглашение</button>
    </div>
</form>
@endsection
