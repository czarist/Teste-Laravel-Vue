@extends('layouts.app')

@section('content')
<div class="col-12 mt-5">
    <regional-norteform :user="{{ $user }}" :regiao="{{ $regiao }}"></regional-norteform>
</div>
@endsection