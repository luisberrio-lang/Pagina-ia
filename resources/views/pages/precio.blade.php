@extends('layouts.marketing')
@section('title', 'Precios · Pagina-IA')

@section('content')
<h2 class="text-3xl font-extrabold">Precios</h2>
<p class="text-white/70 mt-2">Planes y detalles por herramienta.</p>

<div class="mt-8 grid gap-5 md:grid-cols-2">
@forelse($tools as $tool)
  <div id="tool-{{ $tool->id }}" class="glass rounded-3xl p-6">
      <div class="text-xs text-white/70">{{ $tool->tag ?? 'IA' }}</div>
      <div class="text-2xl font-bold mt-1">{{ $tool->title }}</div>
      <div class="text-white/70 mt-2">{{ $tool->subtitle }}</div>

      <div class="mt-4 text-white font-bold text-xl">
        {{ $tool->price ?? 'Consultar' }}
      </div>

      @if($tool->details)
        <div class="mt-3 text-white/70 whitespace-pre-line">{{ $tool->details }}</div>
      @endif

      <div class="mt-5 flex gap-3">
        <a class="btn-primary" href="{{ route('soporte') }}">Contratar</a>
        <a class="btn-tech" href="{{ route('herramientas') }}">Volver</a>
      </div>
  </div>
@empty
  <div class="glass rounded-3xl p-8 text-white/70">
    Aún no hay planes creados.
  </div>
@endforelse
</div>
@endsection
