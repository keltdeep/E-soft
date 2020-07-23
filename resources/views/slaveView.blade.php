@extends('layouts.app')


@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">{{ __('Slave') }}</div>

                    <div class="card-body">

                        @csrf

                        <img src="{{$slave['image']}}" class="card-img-top" alt="image">
                        <div>{{$slave['name']}}</div>



                        <div>agility={{$slave['agility']}}

                        </div>


                        <div>intelligence={{$slave['intelligence']}}

                        </div>


                        <div>cost={{round($slave['cost'], 2)}}</div>

                        <div>rateComfort={{round($slave['rateComfort'], 2)}}</div>

                        <div>dailyExpenses={{round($slave['dailyExpenses'], 2)}}</div>

                        @if($slave['master'] !== null)
                        <a href={{$slave['id']}}/edit class="btn">edit</a>
@endif



                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
