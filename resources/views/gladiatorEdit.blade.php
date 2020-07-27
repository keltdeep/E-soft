@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-7">
                <div class="card">
                    <div class="card-header">Гладиатор {{$gladiator['name']}}</div>

                    <div class="card-body">

                        @csrf

                        @if ($errors->any())
                            <div class="alert alert-danger">
                                <ul>
                                    @foreach ($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                            </div><br/>
                        @endif

                        <form method="POST" action="/gladiator/{{$gladiator['id']}}" enctype='multipart/form-data'>
                            <div class="card" style="width: 18rem;">
                                @if(isset($gladiator['image']))
                                    <img class="card-img-top" src="{{$gladiator['image']}}" alt="">
                                @endif
                                {{method_field('PATCH')}}
                                {{ csrf_field() }}


                                <div class="form-group row">
                                    <label for="strength"
                                           class="col-md-5 col-form-label text-md-right">Сила [{{$gladiator['strength']}}]</label>
                                    <div class="col-md-5">
                                        <input id="strength" type="number" name="strength" class="form-control"
                                               value="1">
                                    </div>
                                </div>

                                <div class="form-group row">
                                    <label for="agility"
                                           class="col-md-5 col-form-label text-md-right">Ловкость [{{$gladiator['agility']}}]</label>
                                    <div class="col-md-5">
                                        <input id="agility" type="number" name="agility" class="form-control" value="1">
                                    </div>
                                </div>

                                <div class="form-group row">
                                    <label for="heals"
                                           class="col-md-5 col-form-label text-md-right">Здоровье [{{$gladiator['heals']}}]</label>
                                    <div class="col-md-5">
                                        <input id="heals" type="number" name="heals" class="form-control" value="1">
                                    </div>
                                </div>

                                    <div>Стоимость Силы {{round($gladiator['costStrength'], 2)}}</div>
                                    <input id="costStrength" type="hidden" name="costStrength" class="form-control"
                                           value="{{round($gladiator['costStrength'], 2)}}">
                                    <div>Стоимость Ловкости {{round($gladiator['costAgility'], 2)}}</div>
                                    <input id="costAgility" type="hidden" name="costAgility" class="form-control"
                                           value="{{round($gladiator['costAgility'], 2)}}">
                                    <div>Стоимость Здоровья {{round($gladiator['costHeals'], 2)}}</div>
                                    <input id="costHeals" type="hidden" name="costHeals" class="form-control"
                                           value="{{round($gladiator['costHeals'], 2)}}">
                                    {{--                            <div>thePossibilityOfDeath={{round($gladiator['thePossibilityOfDeath'], 2)}}</div>--}}
                                    {{--                            <input id="thePossibilityOfDeath" type="hidden" name="thePossibilityOfDeath" class="form-control" value="{{round($gladiator['thePossibilityOfDeath'], 2)}}">--}}

                                    <div>Дневной Доход {{round($gladiator['rate'], 2)}}</div>

                                <button type="submit" class="btn btn-primary">
                                    Тренировать
                                </button>
                            </div>
                        </form>

                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
