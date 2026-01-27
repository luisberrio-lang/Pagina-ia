@extends('layouts.marketing')
@section('title', 'Inicio · GVelarde')

@section('content')
<section class="grid gap-10 lg:grid-cols-2 items-center">

  {{-- IZQUIERDA --}}
  <div>
    <div class="inline-flex items-center gap-2 rounded-full bg-white/5 border border-white/10 px-4 py-2 text-xs text-white/70">
      <span class="h-2 w-2 rounded-full bg-emerald-400"></span>
      Catálogo de herramientas de IA
    </div>

    <h1 class="mt-6 text-4xl sm:text-5xl font-extrabold leading-tight">
      La central de las mejores herramientas de <span class="text-cyan-300">IA</span> en un solo lugar.
    </h1>

    <p class="mt-4 text-white/70 max-w-xl leading-relaxed">
      Todas las herramientas de inteligencia artificial más populares que necesitas, sin límites.
    </p>

    <div class="mt-7 flex flex-wrap gap-3">
      <a href="{{ route('herramientas') }}" class="btn-primary">Ver Planes</a>
      <a href="{{ route('precio') }}" class="btn-tech">Ver precios</a>
    </div>
  </div>

  {{-- DERECHA --}}
  <div class="glass rounded-3xl p-6 md:p-8 border border-white/10">
    <div class="flex items-start justify-between gap-4">
      <div>
        <h3 class="text-lg md:text-xl font-extrabold">¿Cómo trabajamos?</h3>
        <p class="text-white/60 mt-1 text-sm">
          Proceso claro, transparente y profesional.
        </p>
      </div>

      <span class="hidden md:inline-flex items-center gap-2 rounded-full px-3 py-2 text-xs"
            style="background: rgba(4,201,24,0.15);
                   border: 1px solid rgba(4,201,24,0.40);
                   color: #04C918;
                   box-shadow: 0 0 12px rgba(4,201,24,0.25);">
        ✅ 100% verificado
      </span>

    </div>

    {{-- Cards --}}
    <div class="mt-6 grid gap-4 sm:grid-cols-2 lg:grid-cols-3">

      {{-- 1 --}}
      <div class="neon-frame neon-gold">
        <div class="neon-inner rounded-2xl p-5 h-full flex flex-col min-h-[260px]">
          <div class="flex items-start justify-between gap-3">
            <p class="font-extrabold text-white/95 text-base leading-snug">
              🧠 Cómo trabajamos
            </p>
            <span class="text-xs text-white/60 mt-1">▶</span>
          </div>

          <p class="text-white/70 mt-3 text-sm leading-relaxed">
            Descubre nuestro proceso de trabajo, cómo operamos y la forma en que brindamos
            nuestros servicios de inteligencia artificial de manera profesional y transparente.
          </p>

          <div class="mt-auto w-full pt-4 flex flex-col items-center gap-2 text-center">
            <span class="text-white/45 text-xs">Proceso</span>

            <a href="https://web.facebook.com/reel/4152099245054712" target="_blank" rel="noopener"
               class="inline-flex min-w-[120px] items-center justify-center rounded-lg px-4 py-1.5 text-xs font-semibold
                      text-white transition whitespace-nowrap"
               style="background:#002AD4;border:1px solid #002AD4;"
               onmouseover="this.style.background='#1A43FF';this.style.borderColor='#1A43FF';"
               onmouseout="this.style.background='#002AD4';this.style.borderColor='#002AD4';">
              Ver video
            </a>

          </div>
        </div>
      </div>

      {{-- 2 --}}
      <div class="neon-frame">
        <div class="neon-inner rounded-2xl p-5 h-full flex flex-col min-h-[260px]">
          <div class="flex items-start justify-between gap-3">
            <p class="font-extrabold text-white/95 text-base leading-snug">
              ✅ 100% confiables
            </p>
            <span class="text-xs text-white/60 mt-1">🔒</span>
          </div>

          <p class="text-white/70 mt-3 text-sm leading-relaxed">
            Revisa experiencias reales, referencias y testimonios de clientes
            que confían en nuestros servicios.
          </p>

          <div class="mt-auto w-full pt-4 flex flex-col items-center gap-2 text-center">
            <span class="text-white/45 text-xs">Referencia</span>

            <a href="https://whatsapp.com/channel/0029Vb70a5sJuyAHgnr9Tw1C" target="_blank" rel="noopener"
               class="inline-flex min-w-[120px] items-center justify-center rounded-lg px-4 py-1.5 text-xs font-semibold
                      text-white transition whitespace-nowrap"
               style="background:#05F545;"
               onmouseover="this.style.background='#2CFF66';"
               onmouseout="this.style.background='#05F545';">
              Ver canal
            </a>

          </div>
        </div>
      </div>

      {{-- 3 --}}
      <div class="neon-frame neon-purple sm:col-span-2 lg:col-span-1">
        <div class="neon-inner rounded-2xl p-5 h-full flex flex-col min-h-[260px]">
          <div class="flex items-start justify-between gap-3">
            <p class="font-extrabold text-white/95 text-base leading-snug">
              👑 Únete a nuestra comunidad
            </p>
            <span class="text-xs text-white/60 mt-1">🤝</span>
          </div>

          <p class="text-white/70 mt-3 text-sm leading-relaxed">
            Forma parte de nuestra comunidad exclusiva y conoce de primera mano
            nuestras novedades y beneficios.
          </p>

          <div class="mt-auto w-full pt-4 flex flex-col items-center gap-2 text-center">
            <span class="text-white/45 text-xs">Acceso</span>

            <a href="https://chat.whatsapp.com/Bb3rE91HltALEzI6ccdLp5" target="_blank" rel="noopener"
               class="inline-flex min-w-[120px] items-center justify-center rounded-lg px-4 py-1.5 text-xs font-semibold
                      text-white transition whitespace-nowrap"
               style="background:#05F545;border:1px solid #05F545;"
               onmouseover="this.style.background='#2CFF66';this.style.borderColor='#2CFF66';"
               onmouseout="this.style.background='#05F545';this.style.borderColor='#05F545';">
              Unirme
            </a>

          </div>
        </div>
      </div>

    </div>
  </div>
</section>

{{-- VIDEO --}}
<section class="mt-12">
  <div class="neon-frame">
    <div class="neon-inner p-6 md:p-8">
      <h2 class="text-2xl md:text-3xl font-extrabold">⏯️Cómo funciona (video)</h2>
      <p class="text-white/70 mt-2">
        Mira una demostración rápida de cómo trabajamos y cómo acceder a los packs.
      </p>

      <div class="mt-6 overflow-hidden rounded-2xl border border-white/10 bg-black/40">
        <div style="position:relative;width:100%;padding-top:56.25%;">
          <iframe
            src="https://www.youtube.com/embed/bv0NZv_Wq04"
            title="Video de YouTube"
            style="position:absolute;inset:0;width:100%;height:100%;border:0;"
            allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share"
            allowfullscreen
          ></iframe>
        </div>
      </div>

      <p class="mt-3 text-xs text-white/50">
        Si el video tarda en cargar, puedes verlo en 720p manteniendo buena calidad.
      </p>
    </div>
  </div>
</section>
@endsection
