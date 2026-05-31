@extends('layouts.marketing')
@section('title', 'Precios Â· Pagina-IA')

@section('content')
@php
    $activeTool = $activeTool ?? null;

    $phone = preg_replace('/\D+/', '', config('services.whatsapp.number', env('WHATSAPP_NUMBER', '51978350894')));

    $toList = function ($value) {
        if (is_array($value)) return array_values(array_filter($value));
        if (is_string($value) && trim($value) !== '') {
            return array_values(array_filter(array_map('trim', preg_split("/\r\n|\n|\r/", $value))));
        }
        return [];
    };
@endphp

<div class="flex items-end justify-between gap-4 flex-wrap">
    <div>
        <h2 class="text-3xl font-extrabold">Precios</h2>
        <p class="text-white/70 mt-2">Planes y detalles por herramienta.</p>
    </div>

    <a href="{{ route('herramientas') }}" class="btn-tech">Volver</a>
</div>

@if($tools->count())
    <div class="mt-6 flex gap-3 overflow-x-auto pb-2">
        @foreach($tools as $t)
            @php
                $isActive = $activeTool && $activeTool->id === $t->id;
                $toolCurrencySymbol = $t->currency_symbol ?? (($t->currency ?? 'PEN') === 'USD' ? '$' : 'S/');
            @endphp
            <a href="{{ route('precio', ['tool' => $t->id]) }}"
               class="shrink-0 glass rounded-2xl px-4 py-3 border
                      {{ $isActive ? 'border-cyan-300/60' : 'border-white/10' }}">
                <div class="text-xs text-white/60">{{ $t->tag ?? 'IA' }}</div>
                <div class="font-semibold">{{ $t->title }}</div>
                <div class="text-xs text-white/60 mt-1 line-clamp-1">
                    {{ $toolCurrencySymbol }} {{ $t->price_monthly ?? $t->price ?? 'Consultar' }}
                </div>
            </a>
        @endforeach
    </div>
@endif

@if($activeTool)
    @php
        $badge = $activeTool->badge_text ?? null;
        $short = $activeTool->short_desc ?? null;
        $highlights = $toList($activeTool->highlights ?? null);
        $includes   = $toList($activeTool->includes ?? null);
        $extras     = $toList($activeTool->extras ?? null);

        $monthly   = $activeTool->price_monthly ?? $activeTool->price ?? null;
        $semestral = $activeTool->price_semestral ?? null;
        $anual     = $activeTool->price_anual ?? null;
        $currencySymbol = $activeTool->currency_symbol ?? (($activeTool->currency ?? 'PEN') === 'USD' ? '$' : 'S/');

        $saveSem   = $activeTool->savings_semestral ?? null;
        $saveAnual = $activeTool->savings_anual ?? null;

        $msg = "Hola, quiero contratar: {$activeTool->title}";
        $waUrl = "https://wa.me/{$phone}?text=" . urlencode($msg);
    @endphp

    <div id="tool-{{ $activeTool->id }}" class="mt-8 glass rounded-3xl p-6 md:p-10 border border-white/10">
        <div class="flex items-start justify-between gap-6 flex-wrap">
            <div class="max-w-2xl">
                <div class="flex items-center gap-2">
                    <span class="text-xs rounded-full bg-white/10 border border-white/10 px-3 py-1 text-white/80">
                        {{ $activeTool->tag ?? 'IA' }}
                    </span>

                    @if($badge)
                        <span class="text-[10px] px-3 py-1 rounded-full font-extrabold shrink-0"
                              style="background:#D3FF00;border:1px solid #D3FF00;color:#000;
                                     box-shadow:0 0 10px rgba(211,255,0,.75),0 0 22px rgba(211,255,0,.45);">
                            {{ $badge }}
                        </span>
                    @endif
                </div>

                <h3 class="mt-4 text-3xl font-extrabold">{{ $activeTool->title }}</h3>
                <p class="mt-2 text-white/70">{{ $activeTool->subtitle }}</p>

                @if($short)
                    <p class="mt-4 text-white/70">{{ $short }}</p>
                @endif

                @if(count($highlights))
                    <div class="mt-5 flex flex-wrap gap-2">
                        @foreach($highlights as $h)
                            <span class="text-xs rounded-full bg-white/10 border border-white/10 px-3 py-1 text-white/80">
                                ✅ {{ $h }}
                            </span>
                        @endforeach
                    </div>
                @endif

                @php
                    $detailsLines = $toList($activeTool->details ?? null);
                @endphp

                @if(count($includes) || count($detailsLines))
                    <div class="mt-6">
                        <div class="text-xs tracking-widest text-white/50">¿QUÉ INCLUYE?</div>
                        <ul class="mt-3 space-y-2 text-white/80">
                            @foreach(count($includes) ? $includes : $detailsLines as $it)
                                <li class="flex gap-2">
                                    <span class="text-cyan-300">•</span> <span>{{ $it }}</span>
                                </li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                @if(count($extras))
                    <div class="mt-6">
                        <div class="text-xs tracking-widest text-white/50">EXTRAS INCLUIDOS</div>
                        <ul class="mt-3 space-y-2 text-white/80">
                            @foreach($extras as $ex)
                                <li class="flex gap-2">
                                    <span class="text-cyan-300">•</span> <span>{{ $ex }}</span>
                                </li>
                            @endforeach
                        </ul>
                    </div>
                @endif
            </div>

            <div class="w-full max-w-md">
                <div class="text-xs tracking-widest text-white/50 mb-3">PRECIOS DEL PLAN</div>

                <div class="grid gap-3 sm:grid-cols-3">
                    <div class="rounded-2xl border border-white/10 bg-white/5 p-4">
                        <div class="text-xs text-white/70">ANUAL</div>
                        <div class="text-2xl font-extrabold mt-2">
                            {{ $currencySymbol }} {{ $anual ?? '—' }}
                        </div>
                        @if($saveAnual)
                            <div class="text-xs text-emerald-300 mt-1">ahorras {{ $currencySymbol }} {{ $saveAnual }}</div>
                        @endif
                    </div>

                    <div class="rounded-2xl border border-white/10 bg-white/5 p-4">
                        <div class="text-xs text-white/70">SEMESTRAL</div>
                        <div class="text-2xl font-extrabold mt-2">
                            {{ $currencySymbol }} {{ $semestral ?? '—' }}
                        </div>
                        @if($saveSem)
                            <div class="text-xs text-emerald-300 mt-1">ahorras {{ $currencySymbol }} {{ $saveSem }}</div>
                        @endif
                    </div>

                    <div class="rounded-2xl border border-white/10 bg-white/5 p-4">
                        <div class="text-xs text-white/70">MENSUAL</div>
                        <div class="text-2xl font-extrabold mt-2">
                            {{ $currencySymbol }} {{ $monthly ?? 'Consultar' }}
                        </div>
                    </div>
                </div>

                <a href="{{ $waUrl }}" target="_blank" rel="noopener"
                   class="mt-6 inline-flex w-full items-center justify-center gap-2 rounded-2xl px-5 py-4 font-semibold
                          text-white transition"
                   style="background:#25D350;box-shadow:0 0 12px rgba(37,211,80,.55),0 0 28px rgba(37,211,80,.30);"
                   onmouseover="this.style.background='#35E062';"
                   onmouseout="this.style.background='#25D350';">
                    <img src="{{ asset('images/pngegg.webp') }}" alt="WhatsApp" class="h-5 w-5" loading="lazy" decoding="async">
                    QUIERO ESTE PLAN por WhatsApp
                </a>

                <p class="mt-3 text-xs text-white/60">
                    Te respondemos con los detalles del plan, ejemplos y pasos para activarlo.
                </p>
            </div>
        </div>
    </div>
@else
    <div class="mt-8 glass rounded-3xl p-8 text-white/70">
        Aún no hay planes/herramientas creadas.
    </div>
@endif
@endsection
