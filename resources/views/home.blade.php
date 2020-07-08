@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">Dashboard</div>

                @csrf

                <div class="card-body">
                    @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif

{{--                        <form method="POST" action="/home" enctype='multipart/form-data'>--}}

{{--                            <input type="hidden" value="{!! csrf_token() !!}" name="_token">--}}
{{--                            <div class="custom-file">--}}
{{--                                <input type="file"--}}
{{--                                       class="custom-file-input"--}}
{{--                                       id="inputGroupFile01"--}}
{{--                                       name="image"--}}
{{--                                       aria-describedby="inputGroupFileAddon01">--}}
{{--                                <label class="custom-file-label" for="inputGroupFile01">Choose file</label>--}}
{{--                            </div>--}}
{{--                            <div>--}}
{{--                                <button type="submit">add foto</button>--}}
{{--                            </div>--}}
{{--                        </form>--}}
<div>
                        <img src="{{$user->image}}" class="card-img-top" alt="image">
</div>
                        @if ($user->administration === true)
                            <div><a href='slave/create' class="btn">create slave</a></div>
                            <div><a href='gladiator/create' class="btn">create gladiator</a></div>
                            <div><a href="updatingIndicators" class="btn">updating indicators</a></div>
                            <div><a href="users" class="btn">users list</a></div>

                        @endif

                       {{$user->name}}


                        <div>Money =  {{round($user->money, 2)}}</div>
                       <div>Rating = {{round($user->rating, 2)}}</div>

                    ПРАВИЛА, АВКА,
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
