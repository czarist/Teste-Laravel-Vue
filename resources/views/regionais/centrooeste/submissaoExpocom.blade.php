@extends('layouts.app')

@section('content')
<div class="col-12 mt-5">
    <submissao-expocom-centrooeste :user="{{ $user }}" :regiao="{{ $regiao }}" :tipo="{{ $tipo }}"></submissao-expocom-centrooeste>
</div>
@endsection
