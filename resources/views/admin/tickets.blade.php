@extends('layouts.marketing')
@section('title', 'Admin · Tickets')

@section('content')
<div class="flex items-center justify-between flex-wrap gap-3">
    <h2 class="text-3xl font-extrabold">Tickets</h2>

    <div class="flex gap-2">
        <a class="btn-tech" href="{{ route('admin.dashboard') }}">Dashboard</a>
        <a class="btn-tech" href="{{ route('admin.tickets') }}">Tickets</a>
    </div>
</div>

<div class="mt-6 glass rounded-3xl p-6">
    <h3 class="text-xl font-bold">Consultas de clientes</h3>
    <p class="text-white/70 mt-2">Vista de tickets funcionando ✅</p>

    <p class="text-white/50 mt-4 text-sm">
        Luego lo conectamos a la tabla support_tickets para listarlos aquí con nombre, email, asunto, mensaje, fecha.
    </p>
</div>
@endsection
