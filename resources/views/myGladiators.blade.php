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
                            @if($value->seller === null)
                            <img src="{{$value->image}}" class="card-img-top" alt="image">

                                <div>name={{$value->name}}</div>
                                <div>strength={{$value->strength}}</div>
                                <div>agility={{$value->agility}}</div>
                                <div>heals={{$value->heals}}</div>
                                <div>cost={{round($value->cost, 2)}}</div>
                                <div>rate={{round($value->rate, 2)}}</div>
                                <div>
                                    <a href=/gladiator/{{$value->id}}/edit class="btn">edit</a>
                                </div>
                                <form method="GET" action="gladiator/sell/{{$value->id}}">
                                    <label for="id"></label>
                                    <input id="id" type="hidden" name="id" class="form-control" value="{{$value->id}}">
                                <button type="submit">Sell</button>
                                </form>
                                @endif

                        @endforeach

                        {{$gladiators->links()}}




                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
