@extends('layouts.app_no_navbar')

@section('content')
<div class="col-12 mt-5">
    <div class="container">
        <div class="section-head style-3 text-center z mb-3">
            <img src="{{ asset('images/logo-principal.png')}}" />
            <h2 class="title">{{  env('APP_NAME') }} </h2>
        </div>
    </div>

    <form-cadastro />
</div>
@endsection

