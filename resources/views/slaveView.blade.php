@extends('layouts.app')


@section('content')
    <div class="container">
        <h5 class="row justify-content-center">Рабыня {{$slave['name']}}</h5>

        <div class="row justify-content-center">

            @csrf

            <div class="card" style="width: 240px; height: 410px">
                @if(isset($slave['image']))
                    <img class="card-img-top" style="max-width: 100%; height: 40%" src="{{$slave['image']}}" alt="">
                @endif

                <div class="card-body">
                    <h5 class="card-title">{{$slave['name']}}</h5>
                    <table style="width: 100%">
                        <tbody>
                        <tr>
                            <td>Ловкость</td>
                            <td>{{$slave['agility']}}</td>
                        </tr>
                        <tr>
                            <td>Интеллект</td>
                            <td>{{$slave['intelligence']}}</td>
                        </tr>
                        <tr>
                            <td>Расход в день</td>
                            <td>{{round($slave['dailyExpenses'], 2)}}</td>
                        </tr>
                        <tr>
                            <td>Показатель комфорта</td>
                            <td>{{round($slave['rateComfort'], 2)}}</td>
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
                        {{round($slave['cost'], 2)}}
                    </div>
                </div>
                @if($slave['master'] == $user->id)
                    <a href={{$slave['id']}}/edit class="btn btn-primary">Тренировать</a>
                @endif
            </div>

        </div>
    </div>
@endsection
