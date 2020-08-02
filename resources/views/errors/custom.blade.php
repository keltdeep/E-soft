@extends('layouts.app')

@section('content')
Exception details: <b>{{ $exception->getMessage() }}</b>
@endsection
