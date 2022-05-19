@extends('layouts.app_2')

@section('content')
    <div class="col-12">
        <lista-trabalhos-expocom-grid :regiao="{{ $regiao }}"></lista-trabalhos-expocom-grid>
    </div>
@endsection
