@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-6">
                <div class="card">
                    <div class="card-header">Ваш Лудус</div>

                    @csrf


                    <div class="card" style="width: 15rem;">
                        @if(isset($user->image))
                            <img class="card-img-top" src="{{$user->image}}" alt="">
                        @endif
                        <div class="card-body">
                            <h5 class="card-title">{{$user->name}}</h5>
                            <table style="width: 100%">
                                <tbody>
                                <tr>
                                    <td>Деньги</td>
                                    <td>{{round($user->money, 2)}}</td>
                                </tr>
                                <tr>
                                    <td>Рейтинг</td>
                                    <td>{{round($user->rating, 2)}}</td>
                                </tr>
                                <tr>
                                    <td>Доход в день</td>
                                    <td>{{round($data, 2)}}</td>
                                </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
            @if ($user->administration === true)
                <div class="card">
                    <div class="card-header">Меню Администратора</div>
                    <table style="width: 100%">
                        <tbody>
                        <tr>
                            <td><a class="stretched-link" href='slave/create' class="btn">Создание рабынь</a></td>
                        </tr>
                        <tr>
                            <td><a class="stretched-link" href='gladiator/create' class="btn">Создание Гладиаторов</a>
                            </td>
                        </tr>
                        <tr>
                            <td><a class="stretched-link" href="updatingIndicators" class="btn">Обновление Рейтинга и
                                    дневного дохода</a></td>
                        </tr>
                        </tbody>
                    </table>
                </div>
            @endif
        </div>
    </div>
@endsection
