@extends('event::layouts.master')

@section('content')
    <h1>Hello World</h1>

    <p>Module: {!! config('event.name') !!}</p>
@endsection
