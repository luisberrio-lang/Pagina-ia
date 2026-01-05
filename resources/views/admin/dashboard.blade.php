@extends('layouts.marketing')
@section('title', 'Admin · Dashboard')

@section('content')
<div class="flex items-center justify-between flex-wrap gap-3">
    <h2 class="text-3xl font-extrabold">Admin · Dashboard</h2>

    <div class="flex gap-2">
        <a class="btn-tech" href="{{ route('admin.dashboard') }}">Dashboard</a>
        <a class="btn-tech" href="{{ route('admin.tickets') }}">Tickets</a>
    </div>
</div>

@if (session('status'))
    <div class="mt-4 glass rounded-2xl p-4 text-white/90">
        {{ session('status') }}
    </div>
@endif

@if ($errors->any())
    <div class="mt-4 glass rounded-2xl p-4 text-white/90">
        <div class="font-bold mb-2">Corrige esto:</div>
        <ul class="list-disc ml-5 text-white/80">
            @foreach($errors->all() as $e) <li>{{ $e }}</li> @endforeach
        </ul>
    </div>
@endif

<div class="mt-6 grid gap-6 lg:grid-cols-2">
    <div class="glass rounded-3xl p-6">
        <h3 class="text-xl font-bold">Crear herramienta</h3>
        <p class="text-white/70 mt-1">Esto aparecerá automáticamente en “Herramientas IA”.</p>

        <form class="mt-5 space-y-4" method="POST" action="{{ route('admin.tools.store') }}">
            @csrf

            <div>
                <label class="text-sm text-white/80">Tag</label>
                <input name="tag" class="mt-1 w-full rounded-xl bg-white/5 border border-white/10 px-4 py-3"
                       placeholder="Chatbot / Leads / Contenido" value="{{ old('tag') }}">
            </div>

            <div>
                <label class="text-sm text-white/80">Título</label>
                <input name="title" required class="mt-1 w-full rounded-xl bg-white/5 border border-white/10 px-4 py-3"
                       placeholder="IA Atención" value="{{ old('title') }}">
            </div>

            <div>
                <label class="text-sm text-white/80">Subtítulo</label>
                <input name="subtitle" required class="mt-1 w-full rounded-xl bg-white/5 border border-white/10 px-4 py-3"
                       placeholder="Responde clientes 24/7 con tono profesional." value="{{ old('subtitle') }}">
            </div>

            <div>
                <label class="text-sm text-white/80">Precio</label>
                <input name="price" class="mt-1 w-full rounded-xl bg-white/5 border border-white/10 px-4 py-3"
                       placeholder="S/50 x mes" value="{{ old('price') }}">
            </div>

            <div>
                <label class="text-sm text-white/80">Detalles del plan</label>
                <textarea name="details" rows="4"
                          class="mt-1 w-full rounded-xl bg-white/5 border border-white/10 px-4 py-3"
                          placeholder="Ej: 1 mes gratis, soporte 24/7, implementación incluida...">{{ old('details') }}</textarea>
            </div>

            <div class="flex items-center gap-3">
                <div class="flex-1">
                    <label class="text-sm text-white/80">Orden</label>
                    <input name="sort_order" type="number" min="0" value="{{ old('sort_order', 0) }}"
                           class="mt-1 w-full rounded-xl bg-white/5 border border-white/10 px-4 py-3">
                </div>

                <label class="flex items-center gap-2 mt-6 text-white/80">
                    <input type="checkbox" name="is_active" {{ old('is_active', true) ? 'checked' : '' }}>
                    Activa
                </label>
            </div>

            <button class="btn-primary w-full" type="submit">Guardar</button>
        </form>
    </div>

    <div class="glass rounded-3xl p-6">
        <h3 class="text-xl font-bold">Herramientas creadas</h3>

        <div class="mt-4 space-y-3">
            @forelse($tools as $tool)
                <div class="rounded-2xl border border-white/10 bg-white/5 p-4 flex items-start justify-between gap-4">
                    <div class="min-w-0">
                        <div class="text-xs text-white/70">
                            {{ $tool->tag ?? 'IA' }} · Orden: {{ $tool->sort_order }} · {{ $tool->is_active ? 'Activa' : 'Inactiva' }}
                        </div>
                        <div class="font-bold">{{ $tool->title }}</div>
                        <div class="text-white/70 text-sm">{{ $tool->subtitle }}</div>
                        @if($tool->price)
                            <div class="text-white/80 text-sm mt-2">💳 <b>{{ $tool->price }}</b></div>
                        @endif
                        @if($tool->details)
                            <div class="text-white/60 text-sm mt-1 truncate">{{ $tool->details }}</div>
                        @endif
                    </div>

                    <form method="POST" action="{{ route('admin.tools.destroy', $tool) }}">
                        @csrf
                        @method('DELETE')
                        <button class="btn-tech" type="submit">Eliminar</button>
                    </form>
                </div>
            @empty
                <div class="text-white/70">Aún no hay herramientas.</div>
            @endforelse
        </div>
    </div>
</div>
@endsection
