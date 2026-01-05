@extends('layouts.app')

@section('header')
<div class="font-semibold text-xl text-gray-800 leading-tight">
    Panel Cliente
</div>
@endsection

@section('content')
<div class="py-8">
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">
            <p class="text-gray-700">Bienvenido, {{ auth()->user()->name }} ✅</p>
            <div class="mt-4 flex gap-4 flex-wrap">
                <a class="underline text-indigo-600" href="{{ route('herramientas') }}">Ver herramientas</a>
                <a class="underline text-indigo-600" href="{{ route('soporte') }}">Soporte</a>
            </div>
        </div>
    </div>
</div>
@endsection
