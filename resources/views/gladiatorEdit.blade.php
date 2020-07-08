@extends('layouts.app')


@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">{{ __('Gladiator') }}</div>

                    <div class="card-body">

                        @csrf

                        @if ($errors->any())
                            <div class="alert alert-danger">
                                <ul>
                                    @foreach ($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                            </div><br />
                        @endif

                        <img src="{{$gladiator['image']}}" class="card-img-top" alt="image">
                        <form method="POST" action="/gladiator/{{$gladiator['id']}}" enctype='multipart/form-data'>

                            {{method_field('PATCH')}}
                            {{ csrf_field() }}
                            <div>{{$gladiator['name']}}</div>

                            <div>strength=<label for="strength">{{$gladiator['strength']}}</label>
                                <input id="strength" type="number" name="strength" class="form-control" value="1">
                            </div>

{{--                                    <div>--}}
{{--                                <button name="strength" type="submit">train</button>--}}
{{--                            </div>--}}

                            <div>agility=<label for="agility">{{$gladiator['agility']}}</label>
                                <input id="agility" type="number" name="agility" class="form-control" value="1">
                            </div>

{{--                                    <div>--}}
{{--                                <button name="agility" type="submit">train</button>--}}
{{--                            </div>--}}

                            <div>heals=<label for="heals">{{$gladiator['heals']}}</label>
                                <input id="heals" type="number" name="heals" class="form-control"value="1">
                            </div>


                            <div>costStrength={{round($gladiator['costStrength'], 2)}}</div>
                            <input id="costStrength" type="hidden" name="costStrength" class="form-control" value="{{round($gladiator['costStrength'], 2)}}">
                            <div>costAgility={{round($gladiator['costAgility'], 2)}}</div>
                            <input id="costAgility" type="hidden" name="costAgility" class="form-control" value="{{round($gladiator['costAgility'], 2)}}">
                            <div>costHeals={{round($gladiator['costHeals'], 2)}}</div>
                            <input id="costHeals" type="hidden" name="costHeals" class="form-control" value="{{round($gladiator['costHeals'], 2)}}">
                            <div>thePossibilityOfDeath={{round($gladiator['thePossibilityOfDeath'], 2)}}</div>
                            <input id="thePossibilityOfDeath" type="hidden" name="thePossibilityOfDeath" class="form-control" value="{{round($gladiator['thePossibilityOfDeath'], 2)}}">

                            <div>rate={{round($gladiator['rate'], 2)}}</div>

                            <div>
                                <button  type="submit">train</button>
                            </div>

{{--foto--}}
{{--                    <div class="custom-file">--}}
{{--                        <input type="file"--}}
{{--                               class="custom-file-input"--}}
{{--                               id="inputGroupFile01"--}}
{{--                               name="image"--}}
{{--                               aria-describedby="inputGroupFileAddon01">--}}
{{--                        <label class="custom-file-label" for="inputGroupFile01">Choose file</label>--}}
{{--                    </div>--}}

                        </form>


                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
