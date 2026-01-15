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
    <div class="flex items-center justify-between gap-3 flex-wrap">
        <div>
            <h3 class="text-xl font-bold">Consultas de clientes</h3>
            <p class="text-white/70 mt-2">Listado conectado a la tabla support_tickets.</p>
        </div>
        <span class="text-xs px-3 py-2 rounded-full bg-white/5 border border-white/10 text-white/70">
            {{ $tickets->total() }} tickets
        </span>
    </div>

    @if($tickets->count() === 0)
        <p class="text-white/60 mt-6">No hay tickets aún.</p>
    @else
        <div class="mt-6 grid gap-4">
            @foreach($tickets as $ticket)
                <div class="rounded-2xl border border-white/10 bg-white/5 p-5">
                    <div class="flex items-center justify-between gap-3 flex-wrap">
                        <div>
                            <p class="text-sm text-white/60">#{{ $ticket->id }} · {{ $ticket->created_at?->format('d/m/Y H:i') }}</p>
                            <h4 class="text-lg font-semibold mt-1">{{ $ticket->subject }}</h4>
                        </div>
                        <span class="text-xs px-3 py-1.5 rounded-full border border-white/10 bg-white/10 text-white/70">
                            {{ ucfirst(str_replace('_', ' ', $ticket->status ?? 'abierto')) }}
                        </span>
                    </div>

                    <div class="mt-4 grid gap-2 text-sm text-white/75">
                        <p><span class="text-white/50">Nombre:</span> {{ $ticket->name }}</p>
                        <p><span class="text-white/50">Correo:</span> {{ $ticket->email }}</p>
                        @if($ticket->user)
                            <p>
                                <span class="text-white/50">Usuario:</span>
                                {{ $ticket->user->name }} (#{{ $ticket->user->id }})
                            </p>
                        @endif
                    </div>

                    <p class="text-white/70 mt-4 whitespace-pre-line">{{ $ticket->message }}</p>
                </div>
            @endforeach
        </div>

        <div class="mt-6">
            {{ $tickets->links() }}
        </div>
    @endif
</div>
@endsection
