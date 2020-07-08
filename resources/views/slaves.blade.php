@extends('layouts.app')


@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">{{ __('Slaves') }}</div>

                    <div class="card-body">
                        @csrf

                        @foreach ($slaves as $key => $value)
                            <img src="{{$value->image}}" class="card-img-top" alt="image">
                            <form method="GET" action="buySlave/{{$value->id}}">

                                <label for="id"></label>
                                <input id="id" type="hidden" name="id" value="{{$value->id}}">
                            <div>name={{$value->name}}</div>
                            <div>agility={{$value->agility}}</div>
                            <div>intelligence={{$value->intelligence}}</div>
                            <div>cost={{round($value->cost, 2)}}</div>
                            <div>rateComfort={{round($value->rateComfort, 2)}}</div>
                            <div>dailyExpenses={{round($value->dailyExpenses, 2)}}</div>

                                <button type="submit">buy</button>
                            </form>
                        @endforeach


                            <div>{{$slaves->links()}}</div>




                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
