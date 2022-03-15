@extends('layouts.app')

@section('content')
<div class="col-12 mt-5">
    <regional-suldesteform :user="{{ $user }}" :regiao="{{ $regiao }}"></regional-suldesteform>
</div>
@endsection
