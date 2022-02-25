@extends('layouts.app')

@section('content')
<div class="col-12 mt-5">

    <filiese-cadastro :user="{{ $user }}"></filiese-cadastro>
</div>
@endsection
