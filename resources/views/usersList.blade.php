@extends('layouts.app')


@section('content')
    <nav aria-label="Page navigation example">
        <ul class="pagination justify-content-center">
            {{$users->links()}}
        </ul>
    </nav>

    <div class="container">
        <div class="row justify-content-center">
{{--                    <div class="col-md-12">--}}

            @csrf


            @foreach ($users as $key => $value)
                <div class="card" style="width: 15rem;">
                    @if(isset($value->image))
                        <img class="card-img-top" src="{{$value->image}}" alt="">
                    @endif
                    <div class="card-body">
                        <h5 class="card-title">{{$value->name}}</h5>
                        <table style="width: 100%">
                            <tbody>
                            <tr>
                                <td>Рейтинг</td>
                                <td>{{$value->rating}}</td>
                            </tr>
                            </tbody>
                        </table>
                    </div>


                    @if ($currentUser->administration)
                            <form method="POST" action="users">
                                <div class="form-check">
                                <input type="hidden" value="{!! csrf_token() !!}" name="_token">
                                <input id="id" type="hidden" name="id" class="form-control" value="{{$value->id}}">

                                    <label class="form-check-label" for="exampleCheck1"></label>
                                    <input id="exampleCheck1"
                                           class="form-check-input"
                                           type="checkbox"
                                           name="administration"
                                           @if($value->administration)
                                           checked
                                    @endif
                                    >

                                </div>
                                <div>
                                    <button class="btn btn-primary" type="submit">Сделать администратором</button>
                                </div>
                            </form>
                    @endif
                </div>
            @endforeach
        </div>
    </div>
{{--    </div>--}}

@endsection

