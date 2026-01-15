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
      @endphp

      <div class="neon-frame {{ $isActive ? 'neon-selected' : '' }}">
        <div class="neon-inner relative p-4 sm:p-5 pb-12 min-h-[175px]">
          <div class="flex items-center justify-between gap-2">
            <div class="text-xs text-white/70 font-semibold uppercase tracking-wide">
              {{ $t->tag ?? 'PACK' }}
            </div>

            @if($t->badge_text)
              <span class="text-[10px] px-3 py-1 rounded-full border border-cyan-300/35 text-cyan-100
                           shadow-[0_0_18px_rgba(34,211,238,0.14)] shrink-0">
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
          <div class="text-cyan-200 font-extrabold text-xl leading-tight">
            {{ $from }}
          </div>

          <a href="{{ route('herramientas', ['tool' => $t->id]) }}#planes"
             class="mt-3 inline-flex w-full items-center justify-center rounded-lg px-3 py-2 text-[12px] font-semibold
                    bg-white/10 border border-white/15 text-white hover:bg-white/15 transition
                    sm:absolute sm:bottom-3 sm:right-3 sm:w-auto">
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
            <span class="text-xs px-3 py-1 rounded-full border border-cyan-300/35 text-cyan-100
                         shadow-[0_0_18px_rgba(34,211,238,0.14)]">
              {{ $activeTool->badge_text }}
            </span>
          @endif

          <h3 class="mt-3 text-3xl font-extrabold">{{ $activeTool->title }}</h3>
          <p class="mt-2 text-white/70">{{ $activeTool->short_desc ?? $activeTool->subtitle }}</p>

          @if(!empty($activeTool->highlights))
            <div class="mt-4 flex flex-wrap gap-2">
              @foreach($activeTool->highlights as $h)
                <span class="inline-flex items-center gap-2 rounded-full bg-white/5 border border-white/12 px-3 py-1 text-sm text-white/85">
                  <span class="h-2 w-2 rounded-full bg-emerald-400"></span>
                  <span class="u-minw-0">{{ $h }}</span>
                </span>
              @endforeach
            </div>
          @endif

          @php
            $includesValue = $activeTool->includes ?? [];
            if (is_string($includesValue)) {
              $includesValue = array_values(array_filter(array_map('trim', preg_split("/\r\n|\n|\r/", $includesValue))));
            }

            $includeRows = [];
            foreach ((array) $includesValue as $row) {
              if (is_array($row)) {
                $label = trim($row['label'] ?? '');
                $text = trim($row['text'] ?? '');
                if ($label !== '' || $text !== '') {
                  $includeRows[] = ['label' => $label, 'text' => $text];
                }
              } else {
                $line = trim((string) $row);
                if ($line !== '') {
                  $includeRows[] = ['label' => '', 'text' => $line];
                }
              }
            }
          @endphp

          @if(count($includeRows))
            <div class="mt-8">
              <div class="text-xs tracking-widest text-white/50">¿QUÉ INCLUYE?</div>
              <div class="mt-4 space-y-2 text-white/85">
                @foreach($includeRows as $row)
                  <div>
                    @if($row['label'] !== '')
                      <span class="font-semibold">{{ $row['label'] }}:</span>
                    @endif
                    {{ $row['text'] }}
                  </div>
                @endforeach
              </div>
            </div>
          @endif

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
              ['key'=>'monthly',    'label'=>'Mensual',    'period'=>'mensual',    'price'=>$activeTool->price_monthly,    'old'=>$activeTool->old_price_monthly,    'off'=>$activeTool->off_monthly],
              ['key'=>'bimestral',  'label'=>'Bimestral',  'period'=>'bimestral',  'price'=>$activeTool->price_bimestral,  'old'=>$activeTool->old_price_bimestral,  'off'=>$activeTool->off_bimestral],
              ['key'=>'trimestral', 'label'=>'Trimestral', 'period'=>'trimestral', 'price'=>$activeTool->price_trimestral, 'old'=>$activeTool->old_price_trimestral, 'off'=>$activeTool->off_trimestral],
              ['key'=>'semestral',  'label'=>'Semestral',  'period'=>'semestral',  'price'=>$activeTool->price_semestral,  'old'=>$activeTool->old_price_semestral,  'off'=>$activeTool->off_semestral],
              ['key'=>'anual',      'label'=>'Anual',      'period'=>'anual',      'price'=>$activeTool->price_anual,      'old'=>$activeTool->old_price_anual,      'off'=>$activeTool->off_anual],
            ];
          @endphp

          <div class="grid gap-4 sm:grid-cols-2 lg:grid-cols-3">
            @foreach($plans as $p)
              @php
                $hasPrice = !is_null($p['price']) && (float)$p['price'] > 0;
                $priceValue = $hasPrice ? (float) $p['price'] : null;
                $price = $hasPrice ? number_format($priceValue, 0) : null;
                $currencyClass = ($priceValue !== null && $priceValue >= 100) ? 'text-2xl' : 'text-3xl';
                $amountClass = ($priceValue !== null && $priceValue >= 100) ? 'text-3xl' : 'text-4xl';

                $hasOld = !is_null($p['old']) && (float)$p['old'] > 0;
                $old = $hasOld ? number_format((float)$p['old'], 0) : null;

                $off = $p['off'];
              @endphp

              <div class="neon-frame {{ $p['key']==='monthly' ? 'neon-gold' : '' }} {{ $p['key']==='anual' ? 'neon-purple' : '' }}">
                <div class="neon-inner p-4">
                  <div class="flex items-start justify-between gap-3">
                    <div class="text-sm font-extrabold text-white/95">
                      {{ $p['label'] }}
                    </div>
                  </div>

                  @if($hasOld)
                    <div class="mt-2 flex items-center gap-2 flex-wrap">
                      <span class="text-xs text-white/55 line-through whitespace-nowrap">
                        S/. {{ $old }}
                      </span>

                      @if(!is_null($off) && (int) $off > 0)
                        <span class="text-[11px] px-2.5 py-1 rounded-full whitespace-nowrap
                                     bg-amber-300/15 border border-amber-200/30 text-amber-100
                                     shadow-[0_0_18px_rgba(250,204,21,0.18)]">
                          {{ (int) $off }}% OFF
                        </span>
                      @endif
                    </div>
                  @endif

                  <div class="mt-3">
                    @if($hasPrice)
                      <div class="flex items-baseline gap-2 text-white leading-none">
                        <span class="{{ $currencyClass }} font-extrabold text-white/90">S/.</span>
                        <span class="{{ $amountClass }} font-extrabold">{{ $price }}</span>
                      </div>

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
                      text-white bg-emerald-500 hover:bg-emerald-400 transition">
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
