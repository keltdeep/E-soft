@extends('layouts.app')

@section('content')
Детали ошибки: <b>Обнаружены проблемы с почтовым ящиком, который вы ввели. Возможно, он не одобрен в нашей системе. Пожалуйста, свяжитесь с технической поддержкой</b>
{{--<form method = POST action="/sendInvite">--}}
{{--    @csrf--}}
{{--    {{csrf_field()}}--}}
{{--    <input type="hidden" id="email" name="email" value="keltdeep@gmail.com">--}}
{{--    <input type="hidden" value="{!! csrf_token() !!}" name="_token">--}}
{{--    <label for="text">Ваше сообщение</label>--}}
{{--    <textarea></textarea>--}}
{{--    <button type="submit">Отправить сообщение</button>--}}
{{--</form>--}}
@endsection
