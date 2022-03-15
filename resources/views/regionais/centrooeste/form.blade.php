@extends('layouts.app')

@section('content')
<div class="col-12 mt-5">
    <regional-centrooeste :user="{{ $user }}" :regiao="{{ $regiao }}"></regional-centrooeste>
</div>
@endsection
