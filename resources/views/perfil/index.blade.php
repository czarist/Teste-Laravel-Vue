@extends('layouts.app')

@section('content')
    <div class="col-12 mt-5">
        <form-perfil :user="{{ $user }}"></form-perfil>
    </div>
@endsection
