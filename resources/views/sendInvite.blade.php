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
{{--<div>{{ $order }}</div>--}}
<form method = POST action="/sendInvite">
    @csrf
    {{csrf_field()}}
    <label for="email">email</label><input type="email" id="email" name="email">
    <input type="hidden" value="{!! csrf_token() !!}" name="_token">
    <button type="submit">send invite</button>
</form>

<div>hallo</div>
</body>
</html>
