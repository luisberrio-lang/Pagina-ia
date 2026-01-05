@extends('layouts.marketing')
@section('title', 'Soporte · Pagina-IA')

@section('content')
<div class="grid gap-8 lg:grid-cols-2 lg:items-start">
    <div>
        <h2 class="text-3xl font-extrabold">Soporte</h2>
        <p class="text-white/70 mt-2">Envíanos tu consulta. Se guarda como ticket en MySQL.</p>

        <div class="mt-6 glass rounded-3xl p-6 card-hover">
            <p class="font-semibold">Recomendación</p>
            <p class="text-white/70 mt-2">Describe tu problema y menciona la herramienta IA.</p>
        </div>
    </div>

    <div class="glass rounded-3xl p-6 md:p-8 card-hover">
        @if(session('ok'))
            <div class="mb-4 rounded-2xl border border-emerald-400/20 bg-emerald-500/10 p-4 text-emerald-200">
                {{ session('ok') }}
            </div>
        @endif

        <form method="POST" action="{{ route('soporte.store') }}" class="space-y-4">
            @csrf

            <div>
                <label class="text-sm text-white/70">Nombre</label>
                <input name="name" value="{{ old('name', auth()->user()->name ?? '') }}"
                       class="mt-1 w-full rounded-2xl bg-white/5 border border-white/10 px-4 py-3 outline-none focus:border-cyan-300/50"
                       required />
                @error('name') <p class="text-sm text-red-300 mt-1">{{ $message }}</p> @enderror
            </div>

            <div>
                <label class="text-sm text-white/70">Correo</label>
                <input name="email" type="email" value="{{ old('email', auth()->user()->email ?? '') }}"
                       class="mt-1 w-full rounded-2xl bg-white/5 border border-white/10 px-4 py-3 outline-none focus:border-cyan-300/50"
                       required />
                @error('email') <p class="text-sm text-red-300 mt-1">{{ $message }}</p> @enderror
            </div>

            <div>
                <label class="text-sm text-white/70">Asunto</label>
                <input name="subject" value="{{ old('subject') }}"
                       class="mt-1 w-full rounded-2xl bg-white/5 border border-white/10 px-4 py-3 outline-none focus:border-cyan-300/50"
                       required />
                @error('subject') <p class="text-sm text-red-300 mt-1">{{ $message }}</p> @enderror
            </div>

            <div>
                <label class="text-sm text-white/70">Mensaje</label>
                <textarea name="message" rows="5"
                          class="mt-1 w-full rounded-2xl bg-white/5 border border-white/10 px-4 py-3 outline-none focus:border-cyan-300/50"
                          required>{{ old('message') }}</textarea>
                @error('message') <p class="text-sm text-red-300 mt-1">{{ $message }}</p> @enderror
            </div>

            <button class="btn-primary w-full" type="submit">Enviar ticket</button>
        </form>
    </div>
</div>
@endsection
