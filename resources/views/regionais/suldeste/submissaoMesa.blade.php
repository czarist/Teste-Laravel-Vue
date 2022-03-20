@extends('layouts.app')

@section('content')
<div class="col-12 mt-5">
    <submissao-sudeste :user="{{ $user }}" :regiao="{{ $regiao }}" :tipo="{{ $tipo }}"></submissao-sudeste>
</div>
@endsection
