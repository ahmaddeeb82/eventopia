@extends('contracts::layouts.master')

@section('content')
    <h1>Hello World</h1>

    <p>Module: {!! config('contracts.name') !!}</p>
@endsection
