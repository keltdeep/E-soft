@extends('layouts.app')


@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">{{ __('Gladiator') }}</div>

                <div class="card-body">
@csrf


                    @foreach ($gladiators as $key => $value)
                        <img src="{{$value->image}}" class="card-img-top" alt="image">
                        <form method="GET" action="buyGladiator/{{$value->id}}">

                            <label for="id"></label>
                            <input id="id" type="hidden" name="id" value="{{$value->id}}">
                        <div>name={{$value->name}}</div>
                        <div>strength={{$value->strength}}</div>
                        <div>agility={{$value->agility}}</div>
                        <div>heals={{$value->heals}}</div>
                        <div>cost={{round($value->cost, 2)}}</div>
                        <div>rate={{round($value->rate, 2)}}</div>
                        <div>


                            <button type="submit">buy</button>
                        </div>
                        </form>

                    @endforeach

                    {{$gladiators->links()}}




                </div>
            </div>
        </div>
    </div>
</div>
@endsection
