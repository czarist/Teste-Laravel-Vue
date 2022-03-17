@extends('layouts.app')

@section('content')
<div class="col-12 mt-5">
    <submissao-sul :user="{{ $user }}" :regiao="{{ $regiao }}"></submissao-sul>
</div>
@endsection
