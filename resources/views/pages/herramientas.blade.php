@extends('layouts.marketing')
@section('title', 'Herramientas IA · Pagina-IA')

@section('content')
<div class="flex items-end justify-between gap-4 flex-wrap">
    <div>
        <h2 class="text-3xl font-extrabold">Herramientas IA</h2>
        <p class="text-white/70 mt-2">Catálogo claro y ordenado. Efectos suaves al pasar y hacer clic.</p>
    </div>
    <a href="{{ route('soporte') }}" class="btn-tech">Soporte</a>
</div>

<div class="mt-8 grid gap-5 sm:grid-cols-2 lg:grid-cols-3">
    @forelse($tools as $tool)
        <div class="glass rounded-3xl p-6 card-hover group">
            <div class="flex items-center justify-between">
                <span class="text-xs rounded-full bg-white/10 border border-white/10 px-3 py-1 text-white/80">
                    {{ $tool->tag ?? 'IA' }}
                </span>
                <span class="text-cyan-300 opacity-80 group-hover:opacity-100 transition">↗</span>
            </div>

            <h3 class="mt-4 text-xl font-bold">{{ $tool->title }}</h3>
            <p class="mt-2 text-white/70">{{ $tool->subtitle }}</p>

            @if(!empty($tool->price))
                <div class="mt-3 text-white/80 font-semibold">{{ $tool->price }}</div>
            @endif

            <div class="mt-5 flex gap-3">
                @php
                    $phone = preg_replace('/\D+/', '', config('services.whatsapp.number', env('WHATSAPP_NUMBER', '51978350894')));
                    $msg = "Hola, quiero contratar: {$tool->title}";
                    $waUrl = "https://wa.me/{$phone}?text=" . urlencode($msg);
                @endphp

                {{-- CONTRATAR (WhatsApp) --}}
                <a class="btn-primary flex-1" href="{{ $waUrl }}" target="_blank" rel="noopener">
                    <span class="inline-flex items-center justify-center gap-2">
                        <img
                            src="{{ asset('images/pngegg.png') }}"
                            alt="WhatsApp"
                            class="h-5 w-5"
                        >
                        Contratar
                    </span>
                </a>

                {{-- VER PLANES (ancla en /precio) --}}
                <a class="btn-tech flex-1" href="{{ route('precio') }}#tool-{{ $tool->id }}">
                    Ver planes
                </a>
            </div>
        </div>
    @empty
        <div class="glass rounded-3xl p-8 text-white/70">
            Aún no hay herramientas creadas. (Admin → Dashboard)
        </div>
    @endforelse
</div>
@endsection
