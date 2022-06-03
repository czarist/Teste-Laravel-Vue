@extends('layouts.app_2')

@section('content')
    @if (isset($regiao_id))
        <div class="col-12">
            <lista-trabalhos-expocom-grid :regiao_id="{{ $regiao_id }}"></lista-trabalhos-expocom-grid>
        </div>
    @endif

    @if (!isset($regiao_id))
        <div class="col-12">
            <lista-trabalhos-expocom-grid></lista-trabalhos-expocom-grid>
        </div>
    @endif

@endsection
