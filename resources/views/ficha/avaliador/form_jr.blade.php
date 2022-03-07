@extends('layouts.app')

@section('content')
    <form-avaliador :user="{{$user}}" :form_jr="{{ $form_jr }}"></form-avaliador>
@endsection
