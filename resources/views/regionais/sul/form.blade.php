@extends('layouts.app')

@section('content')
<div class="col-12 mt-5">
    <regional-sulform :user="{{ $user }}" :regiao="{{ $regiao }}"></regional-sulform>
</div>
@endsection
