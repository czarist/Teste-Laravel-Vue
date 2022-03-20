@extends('layouts.app')

@section('content')
<div class="col-12 mt-5">
    <submissao-nordeste :user="{{ $user }}" :regiao="{{ $regiao }}" :tipo="{{ $tipo }}"></submissao-nordeste>
</div>
@endsection
