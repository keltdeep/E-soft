@extends('layouts.app')


@section('content')
    <div class="container">
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

            <form method = POST action="/tech">
                @csrf
                {{csrf_field()}}
                <input type="hidden" value="{!! csrf_token() !!}" name="_token">
                <input type="hidden" value="keltdeep2@yandex.ru" name="email">
          <div>
              <textarea autofocus placeholder="Ваше сообщение" required name="message"></textarea>
          </div>
                <button type="submit">Отправить сообщение в тех. поддержку</button>
            </form>
@endsection
