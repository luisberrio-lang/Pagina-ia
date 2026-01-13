@extends('layouts.marketing')
@section('title', 'Inicio · GVelarde')

@section('content')
<section class="grid gap-10 lg:grid-cols-2 items-center">

    {{-- IZQUIERDA: HERO --}}
    <div>
        <div class="inline-flex items-center gap-2 rounded-full bg-white/5 border border-white/10 px-4 py-2 text-xs text-white/70">
            <span class="h-2 w-2 rounded-full bg-emerald-400"></span>
            Mostrador de herramientas IA
        </div>

        <h1 class="mt-6 text-4xl sm:text-5xl font-extrabold leading-tight">
            La central de las mejores <span class="text-cyan-300">IA</span> en un solo lugar.
        </h1>

        <p class="mt-4 text-white/70 max-w-xl leading-relaxed">
            Todas las inteligencias artificiales más populares que necesitas, sin límites.
        </p>

        <div class="mt-7 flex flex-wrap gap-3">
            <a href="{{ route('herramientas') }}" class="btn-primary">
                Ver herramientas
            </a>
            <a href="{{ route('precio') }}" class="btn-tech">
                Ver precios
            </a>
        </div>
    </div>

    {{-- DERECHA: PANEL --}}
    <div class="glass rounded-3xl p-6 md:p-8 border border-white/10">
        <div class="flex items-start justify-between gap-4">
            <div>
                <h3 class="text-lg md:text-xl font-extrabold">¿Cómo trabajamos?</h3>
                <p class="text-white/60 mt-1 text-sm">
                    Proceso claro, transparente y profesional.
                </p>
            </div>

            <span class="hidden md:inline-flex items-center gap-2 rounded-full bg-white/5 border border-white/10 px-3 py-2 text-xs text-white/70">
                ✅ 100% verificado
            </span>
        </div>

        {{-- ✅ MÁS ORDENADO:
             - 3 columnas pero con “aire”
             - tarjetas más ANCHAS (en lg) y con altura pareja
             - texto completo (sin "...")
        --}}
        <div class="mt-6 grid gap-4 sm:grid-cols-2 lg:grid-cols-3">

            {{-- CARD 1 --}}
            <div class="neon-frame neon-gold">
                <div class="neon-inner rounded-2xl p-5 h-full flex flex-col min-h-[240px]">
                    <div class="flex items-start justify-between gap-3">
                        <p class="font-extrabold text-white/95 text-base leading-snug">
                            🧠 Cómo trabajamos
                        </p>
                        <span class="text-xs text-white/60 mt-1">▶</span>
                    </div>

                    <p class="text-white/70 mt-3 text-sm leading-relaxed break-words">
                        Descubre nuestro proceso de trabajo, cómo operamos y la forma en que brindamos
                        nuestros servicios de inteligencia artificial de manera profesional y transparente.
                    </p>

                    <div class="mt-auto pt-4 flex items-center justify-between gap-3">
                        <span class="text-white/45 text-xs">Proceso</span>

                        <a href="https://web.facebook.com/reel/4152099245054712"
                           target="_blank" rel="noopener"
                           class="inline-flex items-center justify-center rounded-lg px-3 py-2 text-xs font-semibold
                                  bg-white/10 border border-white/15 text-white hover:bg-white/15 transition">
                            Ver video
                        </a>
                    </div>
                </div>
            </div>

            {{-- CARD 2 --}}
            <div class="neon-frame">
                <div class="neon-inner rounded-2xl p-5 h-full flex flex-col min-h-[240px]">
                    <div class="flex items-start justify-between gap-3">
                        <p class="font-extrabold text-white/95 text-base leading-snug">
                            ✅ 100% confiables
                        </p>
                        <span class="text-xs text-white/60 mt-1">🔒</span>
                    </div>

                    <p class="text-white/70 mt-3 text-sm leading-relaxed break-words">
                        Revisa experiencias reales, referencias y testimonios de clientes
                        que confían en nuestros servicios.
                    </p>

                    <div class="mt-auto pt-4 flex items-center justify-between gap-3">
                        <span class="text-white/45 text-xs">Referencias</span>

                        <a href="https://whatsapp.com/channel/0029VbCWdafHLHQh0lpDW31J"
                           target="_blank" rel="noopener"
                           class="inline-flex items-center justify-center rounded-lg px-3 py-2 text-xs font-semibold
                                  bg-emerald-500/90 hover:bg-emerald-400 text-white transition">
                            Ver canal
                        </a>
                    </div>
                </div>
            </div>

            {{-- CARD 3 --}}
            <div class="neon-frame neon-purple sm:col-span-2 lg:col-span-1">
                <div class="neon-inner rounded-2xl p-5 h-full flex flex-col min-h-[240px]">
                    <div class="flex items-start justify-between gap-3">
                        <p class="font-extrabold text-white/95 text-base leading-snug">
                            👑 Únete a nuestra comunidad
                        </p>
                        <span class="text-xs text-white/60 mt-1">🤝</span>
                    </div>

                    <p class="text-white/70 mt-3 text-sm leading-relaxed break-words">
                        Forma parte de nuestra comunidad exclusiva y conoce de primera mano
                        nuestras novedades y beneficios.
                    </p>

                    <div class="mt-auto pt-4 flex items-center justify-between gap-3">
                        <span class="text-white/45 text-xs">Acceso</span>

                        <a href="https://chat.whatsapp.com/Bb3rE91HltALEzI6ccdLp5"
                           target="_blank" rel="noopener"
                           class="inline-flex items-center justify-center rounded-lg px-3 py-2 text-xs font-semibold
                                  bg-white/10 border border-white/15 text-white hover:bg-white/15 transition">
                            Unirme
                        </a>
                    </div>
                </div>
            </div>

        </div>
    </div>
</section>
{{-- =======================
   SECCIÓN VIDEO
   ======================= --}}
<section class="mt-12">
    <div class="neon-frame">
        <div class="neon-inner p-6 md:p-8">
            <div class="flex items-end justify-between gap-4 flex-wrap">
                <div>
                    <h2 class="text-2xl md:text-3xl font-extrabold">Cómo funciona (video)</h2>
                    <p class="text-white/70 mt-2">
                        Mira una demostración rápida de cómo trabajamos y cómo acceder a los packs.
                    </p>
                </div>
            </div>

            <div class="mt-6 overflow-hidden rounded-2xl border border-white/10 bg-black/40">
                <video
                    class="w-full"
                    controls
                    playsinline
                    preload="metadata"
                    poster="{{ asset('images/robot-3d.png') }}"
                >
                    <source src="{{ asset('videos/demo.mp4') }}" type="video/mp4">
                    Tu navegador no soporta video HTML5.
                </video>
            </div>

            <p class="mt-3 text-xs text-white/50">
                Consejo: si el video demora en cargar, puedes bajarlo a 720p sin perder calidad notable.
            </p>
        </div>
    </div>
</section>

@endsection
