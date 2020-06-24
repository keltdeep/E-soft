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

                            <form method="GET" action="buySlave/{{$value->id}}">

                                <label for="id"></label>
                                <input id="id" type="hidden" name="id" value="{{$value->id}}">
                            <div>name={{$value->name}}</div>
                            <div>agility={{$value->agility}}</div>
                            <div>intelligence={{$value->intelligence}}</div>
                            <div>cost={{$value->cost}}</div>
                            <div>rateComfort={{$value->rateComfort}}</div>
                            <div>dailyExpenses={{$value->dailyExpenses}}</div>
                                <button type="submit">buy</button>
                            </form>
                        @endforeach
                        git stat

                            <div>{{$slaves->links()}}</div>




                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
