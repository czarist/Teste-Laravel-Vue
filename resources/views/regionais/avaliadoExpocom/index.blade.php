@extends('layouts.app')

@section('content')

    @if (\Carbon\Carbon::now()->format('Y-m-d H:i:s') <= '2022-06-01 00:00:00')
        <div class="col-12">
            <submissao-expocom-grid />
        </div>    
    @else
        <div class="col-12">
            <submissao-expocom-sem-video-grid />
        </div>
    @endif
@endsection
