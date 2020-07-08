@extends('layouts.app')


@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">{{ __('Gladiator') }}</div>

                    <div class="card-body">

                                                @csrf

                        <img src="{{$gladiator['image']}}" class="card-img-top" alt="image">
                        <div>{{$gladiator['name']}}</div>
                        <div>strength={{$gladiator['strength']}}
                        </div>
                        <div>agility={{$gladiator['agility']}}
                        </div>
                        <div>heals={{$gladiator['heals']}}
                        </div>
                        <div>cost={{round($gladiator['cost'], 2)}}</div>
                        <div>rate={{round($gladiator['rate'], 2)}}</div>
                        <a href={{$gladiator['id']}}/edit class="btn">edit</a>


                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
