@extends('layouts.app')

@section('content')
<div class="col-12 mt-5">
    <inscricao-nacional :user="{{ $user }}"></inscricao-nacional>
</div>
@endsection