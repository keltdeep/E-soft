@extends('layouts.app')


@section('content')
    <div class="container">
        <h5 class="row justify-content-center">Результаты последней Арены</h5>
        <div class="row justify-content-center">Бой начнется когда наберется 4 участника</div>

        <div class="row justify-content-center">

            @csrf


            @foreach ($gladiators as $key => $value)
                <div class="card" style="width: 240px; height: 410px">
                        @if(isset($value->image))
                            <img class="card-img-top" style="max-width: 100%; height: 40%" src="{{$value->image}}" alt="">
                        @endif
                        <div class="card-body">
                            <h5 class="card-title">{{$value->name}}</h5>
                            <table style="width: 100%">
                                <tbody>
                                <tr>
                                    <td>Сила</td>
                                    <td>{{$value->strength}}</td>
                                </tr>
                                <tr>
                                    <td>Ловкость</td>
                                    <td>{{$value->agility}}</td>
                                </tr>
                                <tr>
                                    <td>Здоровье</td>
                                    <td>{{$value->heals}}</td>
                                </tr>
                                <tr>
                                    <td>Доход в день</td>
                                    <td>{{round($value->rate, 2)}}</td>
                                </tr>

                                @foreach($users as $keyUser => $valueUser)
                                    @if($value->master == $valueUser->id)
                                <tr>
                                    <td>Владелец {{$valueUser->name}}</td>
                                </tr>
                                @endif
                                @endforeach
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
                        </div>
    </div>
    @endforeach

    </div>
        <a class="row justify-content-center" href="/lastArena" class="btn">Результаты предыдущей Арены</a>

    </div>

@endsection
