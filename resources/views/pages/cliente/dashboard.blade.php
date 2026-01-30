@extends('layouts.app')

@section('header')
<div class=\"font-semibold text-xl text-gray-800 leading-tight\">
    Panel Cliente
</div>
@endsection

@section('content')
@include('pages.cliente.partials.dashboard-content')
@endsection