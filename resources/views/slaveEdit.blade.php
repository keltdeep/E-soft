@extends('layouts.app')

@section('content')
    <div class="container">
        @if ($errors->any())
            <div class="alert alert-danger">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div><br/>
        @endif
        <h5 class="row justify-content-center">Рабыня {{$slave['name']}}</h5>

        <div class="row justify-content-center">
{{--            <div class="col-md-7">--}}
{{--                <div class="card">--}}
{{--                    <div class="card-header">Рабыня {{$slave['name']}}</div>--}}

{{--                    <div class="card-body">--}}

                        @csrf


            <div class="card" style="width: 300px; height: 450px">
                @if(isset($slave['image']))
                    <img class="card-img-top" style="max-width: 100%; height: 40%" src="{{$slave['image']}}" alt="">
                @endif
                        <form method="POST" action="/slave/{{$slave['id']}}" style="margin-top: 10px" enctype='multipart/form-data'>

                                {{method_field('PATCH')}}
                                {{ csrf_field() }}



                                <div class="form-group row">
                                    <label for="agility"
                                           class="col-md-5 col-form-label text-md-right">Ловкость [{{$slave['agility']}}]</label>
                                    <div class="col-md-5">
                                        <input id="agility" type="number" name="agility" class="form-control" value="1">
                                    </div>
                                </div>

                                <div class="form-group row">
                                    <label for="intelligence"
                                           class="col-md-5 col-form-label text-md-right">Интеллект [{{$slave['intelligence']}}]</label>
                                    <div class="col-md-5">
                                        <input id="intelligence" type="number" name="intelligence" class="form-control" value="1">
                                    </div>
                                </div>
<div style="margin-left: 10px">
                                    <div>Стоимость Ловкости {{round($slave['costAgility'], 2)}}</div>
                                    <input id="costAgility" type="hidden" name="costAgility" class="form-control" value="{{round($slave['costAgility'], 2)}}">
                                    <div>Стоимость Интеллекта {{round($slave['costIntelligence'], 2)}}</div>
                                    <input id="costIntelligence" type="hidden" name="costIntelligence" class="form-control" value="{{round($slave['costIntelligence'], 2)}}">
                                    <div>Расход в день {{round($slave['dailyExpenses'], 2)}}</div>
                                    <div>Показатель Комфорта {{round($slave['rateComfort'], 2)}}</div>

                                <button type="submit" class="btn btn-primary">
                                    Тренировать
                                </button>
</div>
                        </form>
            </div>
                    </div>
{{--                </div>--}}
{{--            </div>--}}
{{--        </div>--}}
{{--    </div>--}}
@endsection
