@extends('layouts.marketing')
@section('title', 'Herramientas IA · GVelarde')

@section('content')
@php
    $phone = preg_replace('/\D+/', '', config('services.whatsapp.number', env('WHATSAPP_NUMBER', '51978350894')));
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
    @php
        $activeTool = $activeTool ?? $tools->first();
    @endphp

    {{-- CARDS SUPERIORES --}}
    <div class="mt-8 grid gap-4 md:grid-cols-3">
        @foreach($tools as $t)
            @php
                $from = $t->price_monthly ? '$'.number_format($t->price_monthly, 0).' / mes' : 'Consultar';
                $isActive = $activeTool && $activeTool->id === $t->id;
            @endphp

            <div class="neon-frame {{ $isActive ? 'neon-selected' : '' }} hover:-translate-y-0.5">
                <div class="neon-inner relative overflow-hidden break-words p-4 sm:p-5 pb-12 min-h-[170px]">

                    <div class="flex items-center justify-between gap-2">
                        <div class="text-xs text-white/70 font-semibold uppercase tracking-wide">
                            {{ $t->tag ?? 'PACK' }}
                        </div>

                        @if($t->badge_text)
                            <span class="text-[10px] px-3 py-1 rounded-full
                                         border border-cyan-300/35 text-cyan-100
                                         shadow-[0_0_18px_rgba(34,211,238,0.14)]
                                         shrink-0 max-w-[130px] truncate">
                                {{ $t->badge_text }}
                            </span>
                        @endif
                    </div>

                    <div class="mt-2 font-extrabold leading-tight line-clamp-2">
                        {{ $t->title }}
                    </div>

                    <div class="text-white/70 text-sm leading-snug mt-1 line-clamp-2">
                        {{ $t->subtitle }}
                    </div>

                    <div class="mt-4 text-xs text-white/50">DESDE</div>

                    <div class="text-cyan-200 font-extrabold text-xl leading-tight">
                        {{ $from }}
                    </div>

                    {{-- ✅ Botón responsive:
                         - En móvil: ancho completo abajo (NO se sale)
                         - En sm+: abajo derecha (como querías) --}}
                    <a href="{{ route('herramientas', ['tool' => $t->id]) }}#planes"
                       class="mt-3 inline-flex w-full items-center justify-center rounded-lg px-3 py-2 text-[12px] font-semibold
                              bg-white/10 border border-white/15 text-white hover:bg-white/15 transition
                              sm:mt-0 sm:w-auto sm:absolute sm:bottom-3 sm:right-3">
                        Ver detalles y planes
                    </a>
                </div>
            </div>
        @endforeach
    </div>

    {{-- PANEL GRANDE --}}
    <div id="planes" class="mt-8 neon-frame">
        <div class="neon-inner p-6 md:p-10" x-data="{ plan: 'mensual' }">
            <div class="grid gap-8 lg:grid-cols-2">

                {{-- IZQUIERDA --}}
                <div>
                    @if($activeTool->badge_text)
                        <span class="text-xs px-3 py-1 rounded-full
                                     border border-cyan-300/35 text-cyan-100
                                     shadow-[0_0_18px_rgba(34,211,238,0.14)]">
                            {{ $activeTool->badge_text }}
                        </span>
                    @endif

                    <h3 class="mt-3 text-3xl font-extrabold">{{ $activeTool->title }}</h3>
                    <p class="mt-2 text-white/70">{{ $activeTool->short_desc ?? $activeTool->subtitle }}</p>

                    @if(!empty($activeTool->highlights))
                        <div class="mt-4 flex flex-wrap gap-2">
                            @foreach($activeTool->highlights as $h)
                                <span class="inline-flex items-center gap-2 rounded-full
                                             bg-white/5 border border-white/12 px-3 py-1 text-sm text-white/85">
                                    <span class="h-2 w-2 rounded-full bg-emerald-400"></span>
                                    <span class="line-clamp-1">{{ $h }}</span>
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

                {{-- DERECHA --}}
                <div>
                    <div class="text-xs tracking-widest text-white/50 mb-4">PRECIOS DEL PACK</div>

                    <div class="grid gap-4 sm:grid-cols-3">
                        {{-- ANUAL --}}
                        <button type="button" @click="plan='anual'" class="neon-frame hover:-translate-y-0.5 text-left">
                            <div class="neon-inner rounded-2xl p-5">
                                <div class="text-xs text-white/70 font-semibold uppercase">Anual</div>
                                <div class="mt-2 text-3xl font-extrabold">
                                    ${{ $activeTool->price_anual ? number_format($activeTool->price_anual, 0) : '0' }}
                                </div>
                            </div>
                        </button>

                        {{-- SEMESTRAL --}}
                        <button type="button" @click="plan='semestral'" class="neon-frame hover:-translate-y-0.5 text-left">
                            <div class="neon-inner rounded-2xl p-5">
                                <div class="text-xs text-white/70 font-semibold uppercase">Semestral</div>
                                <div class="mt-2 text-3xl font-extrabold">
                                    ${{ $activeTool->price_semestral ? number_format($activeTool->price_semestral, 0) : '0' }}
                                </div>
                            </div>
                        </button>

                        {{-- MENSUAL --}}
                        <button type="button" @click="plan='mensual'" class="neon-frame hover:-translate-y-0.5 text-left">
                            <div class="neon-inner rounded-2xl p-5">
                                <div class="text-xs text-white/70 font-semibold uppercase">Mensual</div>
                                <div class="mt-2 text-3xl font-extrabold">
                                    ${{ $activeTool->price_monthly ? number_format($activeTool->price_monthly, 0) : '0' }}
                                    <span class="text-base font-semibold text-white/70">/ mes</span>
                                </div>
                            </div>
                        </button>
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

                    {{-- ✅ SOLO WHATSAPP --}}
                    <div class="mt-10">
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
