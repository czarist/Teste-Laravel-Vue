@extends('layouts.app_2')

@section('content')
    <div class="col-12">
        <lista-trabalhos-grid :regiao="{{ $regiao }}"></lista-trabalhos-grid>
    </div>
@endsection
