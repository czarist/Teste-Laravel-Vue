@extends('layouts.app')

@section('content')
<div class="col-12 mt-5">
    <submissao-expocom-sul :user="{{ $user }}" :regiao="{{ $regiao }}" :tipo="{{ $tipo }}"></submissao-expocom-sul>
</div>
@endsection
