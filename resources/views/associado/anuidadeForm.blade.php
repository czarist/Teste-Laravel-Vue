@extends('layouts.app')

@section('content')
<div class="col-12 mt-5">

    <anuidade-cadastro :user="{{ $user }}"></anuidade-cadastro>
</div>
@endsection
