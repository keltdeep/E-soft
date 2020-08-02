@extends('layouts.app')

@section('content')
    Детали ошибки: <b>{{$exception->getMessage()}}</b>

@endsection
