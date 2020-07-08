@extends('layouts.app')


@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">{{ __('User') }}</div>

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


                <form method="POST" action="profile" enctype='multipart/form-data'>

                    <div>Name = <label for="name">{{$user->name}}</label>
                    <input id="name" type="text" name="name" class="form-control">
                    </div>

                    <label for="id"></label>
                    <input id="id" type="hidden" name="id" class="form-control" value="{{$user->id}}">

                            <div>email=<label for="email">{{$user->email}}</label>
                                <input id="email" type="email" name="email" class="form-control">
                            </div>


                            <div>password=<label for="password"></label>
                                <input id="password" type="password" name="password" class="form-control">
                            </div>


                            <div>
                                <div class="form-group row mb-0">
                                    <div class="col-md-6 offset-md-4">
                                        <input type="hidden" value="{!! csrf_token() !!}" name="_token">
                                        <div class="custom-file">
                                            <input type="file"
                                                   class="custom-file-input"
                                                   id="inputGroupFile01"
                                                   name="image"
                                                   aria-describedby="inputGroupFileAddon01">
                                            <label class="custom-file-label" for="inputGroupFile01">Choose file</label>
                                        </div>
<div>
                                        <button type="submit">edit</button>
                                    </div></div></div></div>
                </form>

                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
