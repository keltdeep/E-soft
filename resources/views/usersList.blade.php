@extends('layouts.app')


@section('content')

    <div class="container">
        <h5 class="row justify-content-center">Лучшие гладиаторы на арене</h5>
        <div class="row justify-content-center">




    @foreach ($gladiators as $key => $value)
        @foreach($value as $key => $value)
        <div class="card" style="width: 8rem;">
            @if(isset($value->image))
                <img class="card-img-top" style="max-width: 100%; height: 40%" src="{{$value->image}}" alt="">
            @endif
            <div class="card-body">
                <h5 class="card-title"><a href="/gladiator/{{$value->id}}">{{$value->name}}</a></h5>
                <table style="width: 100%">
                    <tbody>
                    <tr>
                        <td>Победы</td>
                        <td>{{$win}}</td>
                    </tr>


                    </tbody>
                </table>
            </div>
        </div>
            @endforeach
    @endforeach
        </div>

    </div>


            <div class="container">
                <h5 class="row justify-content-center">Список Лудусов по Рейтингу</h5>
                <nav aria-label="Page navigation example">
                    <ul class="pagination justify-content-center">
                        {{$users->links()}}
                    </ul>
                </nav>
                <div class="row justify-content-center">
                    {{--                    <div class="col-md-12">--}}

                    @csrf



                    @foreach ($users as $key => $value)
                        <div class="card" style="width: 240px; height: 410px">
                            @if(isset($value->image))
                                <img class="card-img-top" style="max-width: 100%; height: 60%" src="{{$value->image}}" alt="">
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



                            @if ($currentUser->administration)
                                <form method="POST" action="users">
                                    <div class="form-check">
                                        <input type="hidden" value="{!! csrf_token() !!}" name="_token">
                                        <input id="id" type="hidden" name="id" class="form-control"
                                               value="{{$value->id}}">
                                        @if($value->administration)
                                            <input id="administration" type="hidden" name="administration"
                                                   class="form-control" value="false">

                                            <div>
                                                <button class="btn btn-primary" type="submit">Забрать права
                                                    администратора
                                                </button>
                                            </div>
                                        @else
                                            <input id="administration" type="hidden" name="administration"
                                                   class="form-control" value="true">

                                            <div>
                                                <button class="btn btn-primary" type="submit">Сделать Администратором
                                                </button>
                                            </div>
                                        @endif

                                        {{--                                    <label class="form-check-label" for="exampleCheck1"></label>--}}
                                        {{--                                    <input id="exampleCheck1"--}}
                                        {{--                                           class="form-check-input"--}}
                                        {{--                                           type="checkbox"--}}
                                        {{--                                           name="administration"--}}
                                        {{--                                           @if($value->administration)--}}
                                        {{--                                           checked--}}
                                        {{--                                    @endif--}}
                                        {{--                                    >--}}

                                    </div>
                                </form>
                            @endif
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        {{--    </div>--}}

@endsection

