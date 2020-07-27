@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">Редактирование профиля</div>

                    <div class="card-body">

                        @csrf

                        @if ($errors->any())
                            <div class="alert alert-danger">
                                <ul>
                                    @foreach ($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                            </div><br/>
                        @endif

                        <form method="POST" action="profile" enctype='multipart/form-data'>
                            <div class="form-group row">
                                <label class="col-md-4 col-form-label text-md-right" for="name">{{$user->name}}</label>
                                <div class="col-md-6">
                                    <input id="name" type="text" name="name" placeholder="Изменить Имя">
                                </div>
                            </div>

                            <input id="id" type="hidden" name="id" value="{{$user->id}}">

                            <div class="form-group row">
                                <label for="email"
                                       class="col-md-4 col-form-label text-md-right">{{$user->email}}</label>
                                <div class="col-md-6">
                                    <input id="email" type="email" pattern="[a-z0-9._%+-]+@[a-z0-9.-]+\.[a-z]{2,4}$" name="email" placeholder="Изменить E-mail">
                                </div>
                            </div>


                            <div class="form-group row">
                                <label class="col-md-4 col-form-label text-md-right" for="password">Изменить
                                    пароль</label>
                                <div class="col-md-6">
                                    <input id="password" type="password" name="password" placeholder="Изменить пароль">
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
                                        <label class="custom-file-label" for="inputGroupFile01">Выберите Аватарку</label>
                                    </div>

                                    <button type="submit" class="btn btn-primary">
                                        Изменить
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
