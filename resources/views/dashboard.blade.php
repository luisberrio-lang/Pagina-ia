@extends('layouts.marketing')
@section('title', 'Admin Dashboard · GVelarde')

@section('content')
@php
  $tools = $tools ?? \App\Models\Tool::orderBy('sort_order')->orderByDesc('id')->get();
@endphp

<div class="flex items-end justify-between gap-4 flex-wrap">
  <div>
    <h2 class="text-3xl font-extrabold">Dashboard Administrador</h2>
    <p class="text-white/70 mt-2">Crea y edita packs con planes por período y descuentos automáticos.</p>
  </div>

  @if(session('status'))
    <div class="text-sm px-4 py-2 rounded-xl bg-white/5 border border-white/10 text-white/80">
      {{ session('status') }}
    </div>
  @endif
</div>

{{-- ... formulario ... --}}

<div class="mt-10">
  <h3 class="text-2xl font-extrabold">Packs existentes</h3>
  <p class="text-white/60 mt-1 text-sm">Edita rápido y sin confusión.</p>

  <div class="mt-6 grid gap-6">
    @forelse($tools as $tool)
      <div class="neon-frame">
        <div class="neon-inner p-6 md:p-8">
          <div class="flex items-start justify-between gap-4 flex-wrap">
            <div class="min-w-0">
              <p class="text-xs text-white/60 uppercase tracking-widest">Pack</p>
              <h4 class="text-xl font-extrabold truncate">{{ $tool->title }}</h4>
              <p class="text-white/60 text-sm mt-1 line-clamp-2">{{ $tool->subtitle }}</p>
            </div>

            <form method="POST" action="{{ route('admin.tools.destroy', $tool) }}"
                  onsubmit="return confirm('¿Eliminar este pack?')">
              @csrf @method('DELETE')
              <button class="btn-tech" type="submit">Eliminar</button>
            </form>
          </div>

          <form method="POST" action="{{ route('admin.tools.update', $tool) }}" class="mt-6 grid gap-6">
            @csrf @method('PUT')

            {{-- ... resto del formulario de edición ... --}}
          </form>
        </div>
      </div>
    @empty
      <div class="glass rounded-2xl p-6 text-white/70">
        No hay herramientas registradas todavía.
      </div>
    @endforelse
  </div>
</div>
@endsection
