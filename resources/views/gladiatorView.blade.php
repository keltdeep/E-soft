@extends('layouts.app')


@section('content')
    <div class="container">
        <div class="row justify-content-center">

                                                @csrf

                        <div class="card" style="width: 15rem;">
                            @if(isset($gladiator['image']))
                                <img class="card-img-top" src="{{$gladiator['image']}}" alt="">
                            @endif

                            <div class="card-body">
                                <h5 class="card-title">{{$gladiator['name']}}</h5>
                                <table style="width: 100%">
                                    <tbody>
                                    <tr>
                                        <td>Сила</td>
                                        <td>{{$gladiator['strength']}}</td>
                                    </tr>
                                    <tr>
                                        <td>Ловкость</td>
                                        <td>{{$gladiator['agility']}}</td>
                                    </tr>
                                    <tr>
                                        <td>Здоровье</td>
                                        <td>{{$gladiator['heals']}}</td>
                                    </tr>
                                    <tr>
                                        <td>Доход в день</td>
                                        <td>{{round($gladiator['rate'], 2)}}</td>
                                    </tr>
                                    <tr>
                                        <td>Вероятность смерти</td>
                                        <td>{{round($gladiator['thePossibilityOfDeath'], 2)}}</td>
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
                                        {{round($gladiator['cost'], 2)}}
                                    </div>
                                </div>

                                <a href={{$gladiator['id']}}/edit class="btn">Тренировать</a>
                        </div>

        </div>
    </div>
@endsection
