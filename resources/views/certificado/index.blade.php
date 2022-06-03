@extends('layouts.app')

@section('content')
    <div class="col-12">
        <certificados-grid :user="{{ $user }}" /></certificados-grid>
    </div>
@endsection
