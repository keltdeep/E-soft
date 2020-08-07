@extends('layouts.app')


@section('content')



    <div class="container">
        <h5 class="row justify-content-center">Мои рабыни</h5>
        <nav aria-label="Page navigation example">
            <ul class="pagination justify-content-center">
                {{$slaves->links()}}
            </ul>
        </nav>
        <div class="row justify-content-center">

                        @csrf

                        @foreach ($slaves as $key => $value)
                            @if($value->seller === null)
                                <div class="card" style="width: 250px; height: 440px">
                                        @if(isset($value->image))
                                            <img class="card-img-top" style="max-width: 100%; height: 40%" src="{{$value->image}}" alt="">
                                        @endif

                                        <div class="card-body">
                                            <h5 class="card-title">{{$value->name}}</h5>
                                            <table style="width: 100%">
                                                <tbody>
                                                <tr>
                                                    <td>Ловкость</td>
                                                    <td>{{$value->agility}}</td>
                                                </tr>
                                                <tr>
                                                    <td>Интеллект</td>
                                                    <td>{{$value->intelligence}}</td>
                                                </tr>
                                                <tr>
                                                    <td>Затраты в день</td>
                                                    <td>{{round($value->dailyExpenses, 2)}}</td>
                                                </tr>
                                                <tr>
                                                    <td>Уровень комфорта</td>
                                                    <td>{{round($value->rateComfort, 2)}}</td>
                                                </tr>
                                                </tbody>
                                            </table>
                                        </div>
                                        <div class="card-body" style="display: flex; justify-content: space-between; align-items: center">
                                            <div class="cost">
                                                <svg style="margin-right: 2px" width="1.5em" height="1.5em" viewBox="0 0 16 16" class="bi bi-cash" fill="green" xmlns="http://www.w3.org/2000/svg">
                                                    <path fill-rule="evenodd" d="M15 4H1v8h14V4zM1 3a1 1 0 0 0-1 1v8a1 1 0 0 0 1 1h14a1 1 0 0 0 1-1V4a1 1 0 0 0-1-1H1z"/>
                                                    <path d="M13 4a2 2 0 0 0 2 2V4h-2zM3 4a2 2 0 0 1-2 2V4h2zm10 8a2 2 0 0 1 2-2v2h-2zM3 12a2 2 0 0 0-2-2v2h2zm7-4a2 2 0 1 1-4 0 2 2 0 0 1 4 0z"/>
                                                </svg>
                                                {{round($value->cost, 2)}}
                                            </div>

                                            <form method="GET" action="slave/sell/{{$value->id}}">
                                                <label for="id"></label>
                                                <input id="id" type="hidden" name="id" class="form-control" value="{{$value->id}}">
                                                <button class="btn btn-primary" type="submit">Продать</button>
                                            </form>

                                        </div>
                                        <a href=/slave/{{$value->id}}/edit class="btn btn-primary">Тренировка</a>
                                </div>
                            @endif
                        @endforeach


        </div>
    </div>
@endsection
