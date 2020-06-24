@extends('layouts.app')


@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">{{ __('Slave') }}</div>

                <div class="card-body">

                    @csrf

                    <form method="POST" action="/slave/{{$slave['id']}}" enctype='multipart/form-data'>

                                                    {{method_field('PATCH')}}
                                                    {{ csrf_field() }}
                        <div>{{$slave['name']}}</div>


                        <div>agility=<label for="agility">{{$slave['agility']}}</label>
                            <input id="agility" type="number" name="agility" class="form-control">
                        </div>


                        <div>intelligence=<label for="intelligence">{{$slave['intelligence']}}</label>
                            <input id="agility" type="number" name="intelligence" class="form-control">
                        </div>


                        <div>cost={{$slave['cost']}}</div>

                        <div>rateComfort={{$slave['rateComfort']}}</div>

                        <div>dailyExpenses={{$slave['dailyExpenses']}}</div>
{{--                        <div class="custom-file">--}}
{{--                            <input type="file"--}}
{{--                                   class="custom-file-input"--}}
{{--                                   id="inputGroupFile01"--}}
{{--                                   name="image"--}}
{{--                                   aria-describedby="inputGroupFileAddon01">--}}
{{--                            <label class="custom-file-label" for="inputGroupFile01">Choose file</label>--}}
{{--                        </div>--}}
                        <div>
                            <button type="submit">train</button>
                        </div>

                    </form>


                </div>
            </div>
        </div>
    </div>
</div>
@endsection
