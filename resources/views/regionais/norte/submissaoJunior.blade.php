@extends('layouts.app')

@section('content')
<div class="col-12 mt-5">

    <submissao-norte :user="{{ $user }}" :regiao="{{ $regiao }}" :tipo="{{ $tipo }}"></submissao-norte>
</div>
@endsection
