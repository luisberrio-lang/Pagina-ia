@extends('layouts.marketing')
@section('title', 'Crear cuenta · Pagina-IA')

@section('content')
<div class="mx-auto max-w-md glass rounded-3xl p-8">
    <h2 class="text-2xl font-extrabold">Crear cuenta</h2>
    <p class="text-white/70 mt-2">Regístrate en Pagina-IA.</p>

    @if ($errors->any())
        <div class="mt-4 rounded-2xl border border-white/10 bg-white/5 p-4 text-white/80">
            <ul class="list-disc ml-5">
                @foreach($errors->all() as $e) <li>{{ $e }}</li> @endforeach
            </ul>
        </div>
    @endif

    <form class="mt-6 space-y-4" method="POST" action="{{ route('register') }}">
        @csrf

        <div>
            <label class="text-sm text-white/80">Nombre</label>
            <input name="name" required value="{{ old('name') }}"
                   class="mt-1 w-full rounded-xl bg-white/5 border border-white/10 px-4 py-3">
        </div>

        <div>
            <label class="text-sm text-white/80">Email</label>
            <input name="email" type="email" required value="{{ old('email') }}"
                   class="mt-1 w-full rounded-xl bg-white/5 border border-white/10 px-4 py-3">
        </div>

        <div>
            <label class="text-sm text-white/80">Password</label>
            <input name="password" type="password" required
                   class="mt-1 w-full rounded-xl bg-white/5 border border-white/10 px-4 py-3">
        </div>

        <div>
            <label class="text-sm text-white/80">Confirmar Password</label>
            <input name="password_confirmation" type="password" required
                   class="mt-1 w-full rounded-xl bg-white/5 border border-white/10 px-4 py-3">
        </div>

        <button class="btn-primary w-full" type="submit">Registrar</button>

        <div class="text-center text-white/70 text-sm">
            ¿Ya tienes cuenta?
            <a class="text-cyan-300 hover:underline" href="{{ route('login') }}">Iniciar sesión</a>
        </div>
    </form>
</div>
@endsection
