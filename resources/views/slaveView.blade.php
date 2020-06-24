@extends('layouts.app')


@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">{{ __('Slave') }}</div>

                    <div class="card-body">

                        @csrf


                        <div>{{$slave['name']}}</div>



                        <div>agility={{$slave['agility']}}

                        </div>


                        <div>intelligence={{$slave['intelligence']}}

                        </div>


                        <div>cost={{$slave['cost']}}</div>

                        <div>rateComfort={{$slave['rateComfort']}}</div>

                        <div>dailyExpenses={{$slave['dailyExpenses']}}</div>

                        <div>
                            <button type="submit">train</button>
                        </div>

                        <a href={{$slave['id']}}/edit class="btn">edit</a>




                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
