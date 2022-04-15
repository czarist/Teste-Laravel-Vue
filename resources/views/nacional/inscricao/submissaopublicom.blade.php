@extends('layouts.app')

@section('content')
<div class="col-12 mt-5">
    <submissao-nacional :user="{{ $user }}" :tipo="{{ $tipo}}"></submissao-nacional>
</div>
@endsection
