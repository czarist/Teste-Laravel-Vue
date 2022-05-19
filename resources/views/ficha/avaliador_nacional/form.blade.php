@extends('layouts.app')

@section('content')
    <form-avaliador-nacional :user="{{$user}}" :tipo="{{ $tipo }}"></form-avaliador-nacional>
@endsection

