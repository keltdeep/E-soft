
@extends('layouts.app')


@section('content')

                        @csrf

                        @foreach ($users as $key => $value)
                                <img src="{{$value->image}}" class="card-img-top" alt="image">

                                <div>name={{$value->name}}</div>

                                <form method="POST" action="users">
                                    <input type="hidden" value="{!! csrf_token() !!}" name="_token">
                                    <label for="id"></label>
                                    <input id="id" type="hidden" name="id" class="form-control" value="{{$value->id}}">
                                    <label for="administration"></label>
                                    <div><input id="administration"
                                                type="checkbox"
                                                name="administration"
                                                @if($value->administration)
                                                checked
                                        @endif
                                    </div>
                                  <div> <button type="submit">get rights</button></div>
                                </form>
                        @endforeach


                        <div>{{$users->links()}}</div>


@endsection
