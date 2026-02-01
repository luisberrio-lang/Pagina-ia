@extends('layouts.marketing')
@section('title', 'Herramientas IA · GVelarde')

@section('content')
@php
  $phone = preg_replace('/\D+/', '', env('WHATSAPP_NUMBER', '51951386898'));
@endphp

<div class="flex items-end justify-between gap-4 flex-wrap">
  <div>
    <h2 class="text-3xl font-extrabold">Herramientas IA</h2>
    <p class="text-white/70 mt-2">Elige un pack y revisa planes, detalles y beneficios.</p>
  </div>
  <a href="{{ route('soporte') }}" class="btn-tech">Soporte</a>
</div>

@if($tools->isEmpty())
  <div class="mt-8 neon-frame">
    <div class="neon-inner p-8 text-white/70">
      Aún no hay packs creados. (Admin → Dashboard)
    </div>
  </div>
@else
  @php $activeTool = $activeTool ?? $tools->first(); @endphp

  {{-- Cards superiores --}}
  <div class="mt-8 grid gap-4 md:grid-cols-3">
    @foreach($tools as $t)
      @php
        $from = $t->price_monthly ? 'S/. '.number_format($t->price_monthly, 0).' mensual' : 'Consultar';
        $isActive = $activeTool && $activeTool->id === $t->id;
        $toolMediaVersion = null;
        if ($t->media_path && \Illuminate\Support\Facades\Storage::disk('public')->exists($t->media_path)) {
          $toolMediaVersion = \Illuminate\Support\Facades\Storage::disk('public')->lastModified($t->media_path);
        }
        $toolMediaVersion = $toolMediaVersion ?? ($t->updated_at?->timestamp ?? time());
        $toolMediaUrl = ($t->media_active && $t->media_path)
          ? asset('storage/' . $t->media_path) . '?v=' . $toolMediaVersion
          : null;
        $toolMediaIsVideo = $t->media_mime && \Illuminate\Support\Str::startsWith($t->media_mime, 'video/');
      @endphp

      <div class="neon-frame {{ $isActive ? 'neon-selected' : '' }}">
        <div class="neon-inner relative p-4 sm:p-5 pb-12 min-h-[175px]">
          @if($toolMediaUrl)
            <div class="mb-4 rounded-xl border border-white/10 bg-white/5 p-2 media-fire-frame">
              <div class="relative min-h-[150px] flex items-center justify-center">
                @if($toolMediaIsVideo)
                  <video class="media-card__media" src="{{ $toolMediaUrl }}" muted loop playsinline autoplay preload="metadata"></video>
                @else
                  <img class="media-card__media" src="{{ $toolMediaUrl }}" alt="Animación del pack"
                       loading="lazy" decoding="async">
                @endif
              </div>
            </div>
          @endif

          <div class="flex items-center justify-between gap-2">
            <div class="text-xs text-white/70 font-semibold uppercase tracking-wide">
              {{ $t->tag ?? 'PACK' }}
            </div>

            @if($t->badge_text)
              <span class="text-[10px] px-3 py-1 rounded-full font-extrabold shrink-0 badge-offer"
                    style="background:#D3FF00;border:1px solid #D3FF00;color:#000;
                           box-shadow:0 0 10px rgba(211,255,0,.75),0 0 22px rgba(211,255,0,.45);">
                {{ $t->badge_text }}
              </span>
            @endif
          </div>

          <div class="mt-2 font-extrabold leading-tight text-white/95">
            {{ $t->title }}
          </div>

          <div class="text-white/70 text-sm leading-snug mt-1">
            {{ $t->subtitle }}
          </div>

          <div class="mt-4 text-xs text-white/50">DESDE</div>
          <div class="font-extrabold text-xl leading-tight price-accent">
            {{ $from }}
          </div>

          <a href="{{ route('herramientas', ['tool' => $t->id]) }}#planes"
             class="mt-3 inline-flex w-full items-center justify-center rounded-lg px-3 py-2 text-[12px] font-semibold
                    text-white transition
                    sm:absolute sm:bottom-3 sm:right-3 sm:w-auto"
             style="background:#1D00F5;border:1px solid #1D00F5;
                    box-shadow:0 0 8px rgba(29,0,245,.55),0 0 22px rgba(29,0,245,.35);"
             onmouseover="this.style.background='#3A1BFF';this.style.borderColor='#3A1BFF';this.style.boxShadow='0 0 10px rgba(29,0,245,.70),0 0 30px rgba(29,0,245,.45)';"
             onmouseout="this.style.background='#1D00F5';this.style.borderColor='#1D00F5';this.style.boxShadow='0 0 8px rgba(29,0,245,.55),0 0 22px rgba(29,0,245,.35)';">
            Ver detalles y planes
          </a>
        </div>
      </div>
    @endforeach
  </div>

  {{-- Panel grande --}}
  <div id="planes" class="mt-8 neon-frame">
    <div class="neon-inner p-6 md:p-10">
      <div class="grid gap-10 lg:grid-cols-2">

        {{-- IZQUIERDA --}}
        <div>
          @if($activeTool->badge_text)
            <span class="text-[12px] px-3 py-1 rounded-full font-extrabold shrink-0 badge-offer"
                  style="background:#D3FF00;border:1px solid #D3FF00;color:#000;
                         box-shadow:0 0 10px rgba(211,255,0,.75),0 0 22px rgba(211,255,0,.45);">
              {{ $activeTool->badge_text }}
            </span>
          @endif

          <h3 class="mt-3 text-3xl font-extrabold">{{ $activeTool->title }}</h3>
          <p class="mt-2 text-white/70">{{ $activeTool->short_desc ?? $activeTool->subtitle }}</p>

          @if(!empty($activeTool->highlights))
            <div class="mt-4 flex flex-wrap gap-2">
              @foreach($activeTool->highlights as $h)
                <span class="inline-flex items-center gap-2 rounded-full bg-white/5 border border-white/12 px-3 py-1 text-sm text-white/85">
                  <span class="h-2.5 w-2.5 rounded-full bg-[#25D350] shadow-[0_0_8px_rgba(37,211,80,0.75)]"></span>
                  <span class="u-minw-0">{{ $h }}</span>
                </span>
              @endforeach
            </div>
          @endif

          <div class="mt-8">
            <div class="text-xs tracking-widest text-white/50">¿QUÉ INCLUYE?</div>
            <div class="mt-4 space-y-2 text-white/85">
              @foreach(($activeTool->includes ?? []) as $row)
                <div>
                  <span class="font-semibold">{{ $row['label'] ?? '' }}:</span>
                  {{ $row['text'] ?? '' }}
                </div>
              @endforeach
            </div>
          </div>

          @if(!empty($activeTool->extras))
            <div class="mt-8">
              <div class="text-xs tracking-widest text-white/50">EXTRAS INCLUIDOS</div>
              <ul class="mt-3 space-y-2 text-white/80 list-disc list-inside">
                @foreach($activeTool->extras as $e)
                  <li>{{ $e }}</li>
                @endforeach
              </ul>
            </div>
          @endif
        </div>

        {{-- DERECHA (PLANES) --}}
        <div>
          <div class="text-xs tracking-widest text-white/50 mb-4">PLANES DEL PACK</div>

          @php
            $plans = [
              ['key'=>'monthly',    'label'=>'Mensual',    'period'=>'mensual',    'price'=>$activeTool->price_monthly,    'old'=>$activeTool->old_price_monthly],
              ['key'=>'bimestral',  'label'=>'Bimestral',  'period'=>'bimestral',  'price'=>$activeTool->price_bimestral,  'old'=>$activeTool->old_price_bimestral],
              ['key'=>'trimestral', 'label'=>'Trimestral', 'period'=>'trimestral', 'price'=>$activeTool->price_trimestral, 'old'=>$activeTool->old_price_trimestral],
              ['key'=>'semestral',  'label'=>'Semestral',  'period'=>'semestral',  'price'=>$activeTool->price_semestral,  'old'=>$activeTool->old_price_semestral],
              ['key'=>'anual',      'label'=>'Anual',      'period'=>'anual',      'price'=>$activeTool->price_anual,      'old'=>$activeTool->old_price_anual],
            ];

            $calcOff = function($old, $new){
              $old = (float)$old; $new = (float)$new;
              if ($old > 0 && $new > 0 && $old > $new) {
                return (int) round((($old - $new) / $old) * 100);
              }
              return null;
            };
          @endphp

          <div class="grid gap-4 sm:grid-cols-2 lg:grid-cols-3">
            @foreach($plans as $p)
              @php
                $hasPrice = !is_null($p['price']) && (float)$p['price'] > 0;
                $price = $hasPrice ? number_format((float)$p['price'], 0) : null;

                $hasOld = !is_null($p['old']) && (float)$p['old'] > 0;
                $old = $hasOld ? number_format((float)$p['old'], 0) : null;

                $off = ($hasOld && $hasPrice) ? $calcOff($p['old'], $p['price']) : null;
              @endphp

              <div class="neon-frame {{ $p['key']==='monthly' ? 'neon-gold' : '' }} {{ $p['key']==='anual' ? 'neon-purple' : '' }}">
                {{-- ✅ más compacto (menos alto) --}}
                <div class="neon-inner p-4">
                  <div class="flex items-start justify-between gap-3">
                    <div class="text-sm font-extrabold text-white/95">
                      {{ $p['label'] }}
                    </div>
                  </div>

                  {{-- ✅ ANTES + OFF en la MISMA línea (nunca se corta) --}}
                  @if($hasOld)
                    <div class="mt-2 inline-flex items-center gap-2 flex-nowrap whitespace-nowrap">
                      <span class="text-xs text-white/55 line-through whitespace-nowrap shrink-0">
                        S/. {{ $old }}
                      </span>

                      @if($off)
                        <span class="text-[11px] px-2.5 py-1 rounded-full whitespace-nowrap shrink-0 font-semibold tracking-wide text-black badge-offer"
                              style="background:#D3FF00;border:1px solid #D3FF00;color:#000;
                                     box-shadow:0 0 10px rgba(211,255,0,.85),0 0 24px rgba(211,255,0,.55);">
                          {{ $off }}% OFF
                        </span>
                      @endif
                    </div>
                  @endif

                  {{-- ✅ PRECIO GRANDE HORIZONTAL (sin /mes) --}}
                  <div class="mt-2">
                    @if($hasPrice)
                      <div class="flex items-end gap-2 text-white leading-none">
                        <span class="text-2xl sm:text-3xl font-bold tracking-tight">S/.</span>
                        <span class="text-4xl font-extrabold">{{ $price }}</span>
                      </div>

                      {{-- ✅ SUBTÍTULO CLARO --}}
                      <div class="mt-2 text-sm text-white/60">
                        S/. {{ $price }} {{ $p['period'] }}
                      </div>
                    @else
                      <div class="text-3xl font-extrabold text-cyan-200 leading-none">
                        Consultar
                      </div>
                      <div class="mt-2 text-sm text-white/55">
                        Consultar {{ $p['period'] }}
                      </div>
                    @endif
                  </div>
                </div>
              </div>
            @endforeach
          </div>

          <div class="mt-8">
            <div class="text-xs tracking-widest text-white/50">¿PARA QUIÉN ES ESTE PACK?</div>
            <p class="mt-3 text-white/70">
              {{ $activeTool->audience ?? 'Ideal para creadores de contenido, marketers y emprendedores.' }}
            </p>
          </div>

          @php
            $msg = "Hola, quiero este pack: {$activeTool->title}";
            $waUrl = "https://wa.me/{$phone}?text=" . urlencode($msg);
          @endphp

          <div class="mt-8">
            <a href="{{ $waUrl }}" target="_blank" rel="noopener"
               class="inline-flex w-full items-center justify-center gap-3 rounded-2xl px-6 py-4 font-extrabold
                      text-white transition"
               style="background:#25D350;box-shadow:0 0 12px rgba(37,211,80,.55),0 0 28px rgba(37,211,80,.30);"
               onmouseover="this.style.background='#35E062';"
               onmouseout="this.style.background='#25D350';">
              <img src="{{ asset('images/pngegg.png') }}" alt="WhatsApp" class="h-6 w-6">
              Contratar por WhatsApp
            </a>
          </div>

          <p class="mt-2 text-xs text-white/50">
            Te respondemos con los detalles del pack, ejemplos de uso y los pasos para activarlo en minutos.
          </p>
        </div>

      </div>
    </div>
  </div>
@endif
@endsection
