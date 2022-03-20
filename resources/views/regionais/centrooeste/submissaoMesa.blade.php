@extends('layouts.app')

@section('content')
<div class="col-12 mt-5">
    <submissao-centrooeste :user="{{ $user }}" :regiao="{{ $regiao }}" :tipo="{{ $tipo }}"></submissao-centrooeste>
</div>
@endsection
