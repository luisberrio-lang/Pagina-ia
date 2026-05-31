<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>@yield('title', 'GVelarde')</title>

  @vite(['resources/css/app.css', 'resources/js/app.js'])

  <link rel="icon" href="{{ asset('favicon.ico') }}?v=4">
  <link rel="icon" type="image/png" href="{{ asset('favicon.png') }}?v=4">
</head>

<body class="min-h-screen bg-[#010014] text-slate-100">

{{-- Fondo tech + robot --}}
<div class="pointer-events-none fixed inset-0 -z-10 overflow-hidden">
  <div class="absolute -top-40 -left-40 h-96 w-96 rounded-full bg-fuchsia-600/20 blur-3xl"></div>
  <div class="absolute top-40 -right-40 h-[28rem] w-[28rem] rounded-full bg-cyan-400/15 blur-3xl"></div>
  <div class="absolute inset-0 bg-[radial-gradient(ellipse_at_top,rgba(99,102,241,0.18),transparent_60%)]"></div>
  <div class="absolute inset-0 opacity-30 [background-image:linear-gradient(to_right,rgba(255,255,255,.06)_1px,transparent_1px),linear-gradient(to_bottom,rgba(255,255,255,.06)_1px,transparent_1px)] [background-size:44px_44px]"></div>
  <img src="{{ asset('images/robot-3d.webp') }}" alt="Robot 3D" class="hero-robot" decoding="async" fetchpriority="low"/>
</div>

@php
  $phoneHeader = preg_replace('/\D+/', '', env('WHATSAPP_NUMBER', '51951386898')); // +51 951 386 898
  $waHeaderUrl = "https://wa.me/{$phoneHeader}?text=" . urlencode("Hola, quiero información 👋");

  $fbUrl = "https://web.facebook.com/reel/4152099245054712";
  $ytUrl = "https://www.youtube.com/@Historiasenc%C3%B3digo";
@endphp

<header class="sticky top-0 z-40 border-b border-white/10 bg-[#040030]/80 backdrop-blur-xl" x-data="{open:false}">
  <nav class="w-full flex items-center justify-between px-4 sm:px-6 py-4">

    {{-- LOGO --}}
    <a href="{{ route('inicio') }}" class="flex items-center gap-3 shrink-0">
      <img src="{{ asset('images/logopagina.webp') }}" alt="G Velarde"
           class="h-10 w-10 rounded-xl object-cover border border-white/10 bg-white/5">
      <span class="font-bold tracking-wide">
        G<span class="text-cyan-300">Velarde</span>
      </span>
    </a>

    {{-- MENU DESKTOP --}}
    <div class="hidden md:flex flex-1 items-center justify-center gap-2">
      <a class="nav-item" href="{{ route('inicio') }}">
        <span class="nav-ico">
          <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
            <path d="M3 10.5 12 3l9 7.5"/><path d="M5 10v10h14V10"/>
          </svg>
        </span>
        Inicio
      </a>

      <a class="nav-item" href="{{ route('herramientas') }}">
        <span class="nav-ico">
          <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
            <path d="M12 2v3"/><path d="M12 19v3"/>
            <path d="M4.2 4.2l2.1 2.1"/><path d="M17.7 17.7l2.1 2.1"/>
            <path d="M2 12h3"/><path d="M19 12h3"/>
            <path d="M4.2 19.8l2.1-2.1"/><path d="M17.7 6.3l2.1-2.1"/>
            <rect x="7" y="7" width="10" height="10" rx="2"/>
          </svg>
        </span>
        Herramientas IA
      </a>

      <a class="nav-item" href="{{ route('precio') }}">
        <span class="nav-ico">
          <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
            <path d="M20.59 13.41 12 22 2 12l8.59-8.59A2 2 0 0 1 12 3h8a2 2 0 0 1 2 2v8a2 2 0 0 1-.59 1.41z"/>
            <path d="M16 8h.01"/>
          </svg>
        </span>
        Precios
      </a>

      <a class="nav-item" href="{{ route('faq') }}">
        <span class="nav-ico">
          {{-- ✅ FAQ icon FIX (completo, no recorta) --}}
          <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round">
            <circle cx="12" cy="12" r="9"></circle>
            <path d="M9.5 9a2.5 2.5 0 0 1 5 0c0 2-2.5 2-2.5 4"></path>
            <path d="M12 17h.01"></path>
          </svg>
        </span>
        FAQ
      </a>
    </div>

    {{-- DERECHA --}}
    <div class="flex items-center gap-3 shrink-0">
      {{-- redes --}}
      <div class="hidden sm:flex items-center gap-2 mr-1">
        <a href="{{ $waHeaderUrl }}" target="_blank" rel="noopener" aria-label="WhatsApp"
           class="h-11 w-11 rounded-xl bg-white/5 border border-white/10 flex items-center justify-center hover:bg-white/10 hover:border-emerald-400/40 transition">
          <img src="{{ asset('images/pngegg.webp') }}" alt="WhatsApp" class="h-7 w-7 icon-bright" decoding="async">
        </a>

        <a href="{{ $fbUrl }}" target="_blank" rel="noopener" aria-label="Facebook"
           class="h-11 w-11 rounded-xl bg-white/5 border border-white/10 flex items-center justify-center hover:bg-white/10 hover:border-sky-400/40 transition">
          <svg class="h-7 w-7 text-sky-300 icon-bright" viewBox="0 0 24 24" fill="currentColor">
            <path d="M22 12a10 10 0 1 0-11.5 9.9v-7H8v-2.9h2.5V9.8c0-2.5 1.5-3.9 3.8-3.9 1.1 0 2.2.2 2.2.2v2.4h-1.2c-1.2 0-1.6.8-1.6 1.5v1.8H17l-.5 2.9h-2.4v7A10 10 0 0 0 22 12z"/>
          </svg>
        </a>

        <a href="{{ $ytUrl }}" target="_blank" rel="noopener" aria-label="YouTube"
           class="h-11 w-11 rounded-xl bg-white/5 border border-white/10 flex items-center justify-center hover:bg-white/10 hover:border-red-400/40 transition">
          <svg class="h-7 w-7 text-red-500 icon-bright" viewBox="0 0 24 24" fill="currentColor">
            <path d="M21.6 7.2a3 3 0 0 0-2.1-2.1C17.9 4.7 12 4.7 12 4.7s-5.9 0-7.5.4A3 3 0 0 0 2.4 7.2 31.4 31.4 0 0 0 2 12a31.4 31.4 0 0 0 .4 4.8 3 3 0 0 0 2.1 2.1c1.6.4 7.5.4 7.5.4s5.9 0 7.5-.4a3 3 0 0 0 2.1-2.1A31.4 31.4 0 0 0 22 12a31.4 31.4 0 0 0-.4-4.8zM10 15.5v-7l6 3.5-6 3.5z"/>
          </svg>
        </a>
      </div>

      {{-- auth --}}
      @guest
        <a class="btn-tech" href="{{ route('login') }}">Iniciar sesión</a>
        <a class="btn-primary hidden sm:inline-flex" href="{{ route('register') }}">Crear cuenta</a>
      @endguest

      @auth
        @if(auth()->user()->isAdmin())
          <a class="btn-tech" href="{{ route('admin.dashboard') }}">Dashboard</a>
        @endif

        <form method="POST" action="{{ route('logout') }}">
          @csrf
          <button type="submit" class="btn-tech">Cerrar sesión</button>
        </form>
      @endauth

      {{-- hamburger móvil --}}
      <button type="button" class="md:hidden btn-tech px-3 py-2" @click="open=!open" aria-label="Menú">
        <svg class="h-5 w-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
          <path d="M4 6h16M4 12h16M4 18h16"/>
        </svg>
      </button>
    </div>
  </nav>

  {{-- MENU MÓVIL --}}
  <div class="md:hidden px-4 pb-4" x-show="open" x-transition>
    <div class="glass rounded-2xl p-3 space-y-1">
      <a class="nav-item w-full" href="{{ route('inicio') }}">Inicio</a>
      <a class="nav-item w-full" href="{{ route('herramientas') }}">Herramientas IA</a>
      <a class="nav-item w-full" href="{{ route('precio') }}">Precios</a>
      <a class="nav-item w-full" href="{{ route('faq') }}">FAQ</a>

      <div class="pt-2 flex gap-2">
        <a href="{{ $waHeaderUrl }}" target="_blank" class="btn-tech flex-1">WhatsApp</a>
        <a href="{{ $fbUrl }}" target="_blank" class="btn-tech flex-1">Facebook</a>
        <a href="{{ $ytUrl }}" target="_blank" class="btn-tech flex-1">YouTube</a>
      </div>
    </div>
  </div>
</header>

<main class="mx-auto max-w-6xl px-4 py-10">
  <div class="content-surface p-6 md:p-10">
    @yield('content')
  </div>
</main>

<footer class="border-t border-white/10 bg-[#040030]/80">
  <div class="mx-auto max-w-6xl px-4 py-10 text-sm flex flex-col md:flex-row gap-3 md:items-center md:justify-between">
    <p class="text-white/70">
      © {{ date('Y') }} <span class="font-semibold text-white/85">G Velarde</span>
    </p>

    <p class="text-white/60 md:text-right">
      <span class="font-semibold text-white/80">La central de las mejores IA</span>
      <span class="text-white/50">en un solo lugar.</span>
    </p>
  </div>
</footer>

</body>
</html>







