@extends('layouts.app')

@section('content')
<div class="col-12 mt-5">
    <regional-nordesteform :user="{{ $user }}" :regiao="{{ $regiao }}"></regional-nordesteform>
</div>
@endsection
