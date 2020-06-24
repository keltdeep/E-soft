@extends('layouts.app')


@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">{{ __('Gladiator') }}</div>

                    <div class="card-body">

                        @csrf

                        <form method="POST" action="/gladiator/{{$gladiator['id']}}" enctype='multipart/form-data'>

                            {{method_field('PATCH')}}
                            {{ csrf_field() }}
                            <div>{{$gladiator['name']}}</div>

                            <div>strength=<label for="strength">{{$gladiator['strength']}}</label>
                                <input id="strength" type="number" name="strength" class="form-control">
                            </div>


                            <div>agility=<label for="agility">{{$gladiator['agility']}}</label>
                                <input id="agility" type="number" name="agility" class="form-control">
                            </div>


                            <div>heals=<label for="heals">{{$gladiator['heals']}}</label>
                                <input id="agility" type="number" name="heals" class="form-control">
                            </div>


                            <div>cost={{$gladiator['cost']}}</div>

                            <div>rate={{$gladiator['rate']}}</div>


{{--foto--}}
{{--                    <div class="custom-file">--}}
{{--                        <input type="file"--}}
{{--                               class="custom-file-input"--}}
{{--                               id="inputGroupFile01"--}}
{{--                               name="image"--}}
{{--                               aria-describedby="inputGroupFileAddon01">--}}
{{--                        <label class="custom-file-label" for="inputGroupFile01">Choose file</label>--}}
{{--                    </div>--}}
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
