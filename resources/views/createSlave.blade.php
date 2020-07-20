@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">{{ __('Create Slave') }}</div>

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

                        <form method="POST" action="/slave" enctype='multipart/form-data'>
                            <div class="form-group row">
                                <label for="name" class="col-md-4 col-form-label text-md-right">{{ __('Name') }}</label>

                                <div class="col-md-6">
                                    <input id="name" type="text" class="form-control @error('name') is-invalid @enderror" name="name" value="{{ old('name') }}" required autocomplete="name" autofocus>

                                    @error('name')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>
                            </div>

                            <div class="form-group row">
                                <label for="agility" class="col-md-4 col-form-label text-md-right">{{ __('Agility') }}</label>

                                <div class="col-md-6">
                                    <input id="agility" type="number" name="agility">
                                </div>
                            </div>

                            <div class="form-group row">
                                <label for="intelligence" class="col-md-4 col-form-label text-md-right">{{ __('intelligence') }}</label>

                                <div class="col-md-6">
                                    <input id="intelligence" type="number" name="intelligence">
                                </div>
                            </div>

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
                                    <button type="submit" class="btn btn-primary">
                                        {{ __('Create') }}
                                    </button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
