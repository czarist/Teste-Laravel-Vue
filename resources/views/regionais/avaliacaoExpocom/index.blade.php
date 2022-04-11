@extends('layouts.app')

@section('content')
    <div class="col-12">
        <avaliacao-expocom-grid :regiao="{{ $regiao }}"></avaliacao-expocom-grid>
    </div>
@endsection
