@extends('layouts.marketing')
@section('title', 'Admin Dashboard · GVelarde')

@section('content')
<div class="flex items-end justify-between gap-4 flex-wrap">
  <div>
    <h2 class="text-3xl font-extrabold">Dashboard Administrador</h2>
    <p class="text-white/70 mt-2">Crea y edita packs con precios por período + precio anterior (OFF automático).</p>
  </div>

@if(session('status'))
  <div class="text-sm px-4 py-2 rounded-xl bg-white/5 border border-white/10 text-white/80">
    {{ session('status') }}
  </div>
@endif
</div>

@php
  $uploadMax = ini_get('upload_max_filesize');
  $postMax = ini_get('post_max_size');
@endphp

<div class="mt-4 text-xs text-white/60">
  Límite de subida (PHP): <span class="text-white/80">{{ $uploadMax }}</span> ·
  POST máx: <span class="text-white/80">{{ $postMax }}</span>
</div>

{{-- =========================
   CREAR NUEVO PACK
   ========================= --}}
<div class="mt-8 neon-frame">
  <div class="neon-inner p-6 md:p-8">
    <h3 class="text-xl font-extrabold">Crear nuevo pack</h3>
    <p class="text-white/60 mt-1 text-sm">Todo organizado por secciones.</p>

    <form method="POST" action="{{ route('admin.tools.store') }}" enctype="multipart/form-data" class="mt-6 grid gap-6">
      @csrf

      {{-- INFO BÁSICA --}}
      <div class="grid gap-4 lg:grid-cols-3">
        <div class="lg:col-span-2">
          <label class="text-sm text-white/80 font-semibold">Título</label>
          <input name="title" value="{{ old('title') }}" class="input-tech" required>
          @error('title') <p class="text-red-300 text-xs mt-1">{{ $message }}</p> @enderror
        </div>

        <div>
          <label class="text-sm text-white/80 font-semibold">Tag (opcional)</label>
          <input name="tag" value="{{ old('tag') }}" class="input-tech" placeholder="PACK / VIDEO / IA">
          @error('tag') <p class="text-red-300 text-xs mt-1">{{ $message }}</p> @enderror
        </div>

        <div class="lg:col-span-2">
          <label class="text-sm text-white/80 font-semibold">Subtítulo</label>
          <input name="subtitle" value="{{ old('subtitle') }}" class="input-tech" required>
          @error('subtitle') <p class="text-red-300 text-xs mt-1">{{ $message }}</p> @enderror
        </div>

        <div>
          <label class="text-sm text-white/80 font-semibold">Badge (opcional)</label>
          <input name="badge_text" value="{{ old('badge_text') }}" class="input-tech" placeholder="Más vendido / Nuevo">
          @error('badge_text') <p class="text-red-300 text-xs mt-1">{{ $message }}</p> @enderror
        </div>

        <div class="lg:col-span-3">
          <label class="text-sm text-white/80 font-semibold">Descripción corta (opcional)</label>
          <input name="short_desc" value="{{ old('short_desc') }}" class="input-tech">
          @error('short_desc') <p class="text-red-300 text-xs mt-1">{{ $message }}</p> @enderror
        </div>
      </div>

      {{-- CONTENIDO --}}
      <div class="grid gap-4 lg:grid-cols-3">
        <div>
          <label class="text-sm text-white/80 font-semibold">Highlights (1 por línea)</label>
          <textarea name="highlights_text" rows="6" class="input-tech">{{ old('highlights_text') }}</textarea>
        </div>

        <div>
          <label class="text-sm text-white/80 font-semibold">Incluye (label|texto por línea)</label>
          <textarea name="includes_text" rows="6" class="input-tech">{{ old('includes_text') }}</textarea>
        </div>

        <div>
          <label class="text-sm text-white/80 font-semibold">Extras (1 por línea)</label>
          <textarea name="extras_text" rows="6" class="input-tech">{{ old('extras_text') }}</textarea>
        </div>

        <div class="lg:col-span-3">
          <label class="text-sm text-white/80 font-semibold">Audiencia (opcional)</label>
          <input name="audience" value="{{ old('audience') }}" class="input-tech">
        </div>
      </div>

      {{-- MEDIA DEL PACK --}}
      <div class="neon-frame">
        <div class="neon-inner p-5 md:p-6">
          <h4 class="font-extrabold text-lg">Video del pack (opcional)</h4>
          <p class="text-white/60 text-sm mt-1">
            Video corto en loop (3–5s, sin sonido) o GIF optimizado.
          </p>

          <div class="mt-4 grid gap-4 sm:grid-cols-2">
            <div>
              <label class="text-sm text-white/80 font-semibold">Archivo (MP4/WebM/GIF)</label>
              <input type="file" name="media" accept="video/mp4,video/webm,image/gif" class="input-tech" data-media-validate>
              <input type="hidden" name="media_selected" value="0" data-media-selected>
              @error('media') <p class="text-red-300 text-xs mt-1">{{ $message }}</p> @enderror
              <p class="text-xs text-white/50 mt-1">Recomendado: 3–5s, &lt; 8MB.</p>
              <p data-media-name class="text-xs text-white/70 mt-1 hidden"></p>
              <p data-media-msg class="text-xs text-red-300 mt-1 hidden"></p>
              <div data-media-preview class="mt-3 hidden"></div>
            </div>

            <div class="flex items-center gap-3 pt-7">
              <input type="hidden" name="media_toggle" value="0" data-media-toggle>
              <input type="hidden" name="media_active" value="0">
              <input id="media_active_new" name="media_active" type="checkbox"
                     class="h-5 w-5 rounded border-white/20 bg-white/5">
              <label for="media_active_new" class="text-white/80 font-semibold">Activar video</label>
            </div>
          </div>
        </div>
      </div>

      {{-- PRECIOS --}}
      <div class="neon-frame">
        <div class="neon-inner p-5 md:p-6">
          <div class="flex items-center justify-between gap-3 flex-wrap">
            <div>
              <h4 class="font-extrabold text-lg">Planes por período</h4>
              <p class="text-white/60 text-sm mt-1">
                Ingresa <b>Precio actual</b> y opcionalmente <b>Precio anterior</b> (para mostrar tachado y calcular OFF).
              </p>
            </div>
            <span class="text-xs px-3 py-2 rounded-full bg-white/5 border border-white/10 text-white/70">
              OFF se calcula solo
            </span>
          </div>

          @php
            $planFields = [
              ['k'=>'monthly',    'name'=>'Mensual'],
              ['k'=>'bimestral',  'name'=>'Bimestral'],
              ['k'=>'trimestral', 'name'=>'Trimestral'],
              ['k'=>'semestral',  'name'=>'Semestral'],
              ['k'=>'anual',      'name'=>'Anual'],
            ];
          @endphp

          <div class="mt-5 grid gap-4 sm:grid-cols-2 lg:grid-cols-5">
            @foreach($planFields as $p)
              <div class="glass rounded-2xl p-4 border border-white/10" data-off-wrapper>
                <p class="font-semibold text-white/85 text-sm">{{ $p['name'] }}</p>

                <label class="text-xs text-white/60 mt-3 block">Precio anterior (tachado)</label>
                <div class="mt-2 flex flex-col gap-2 sm:flex-row sm:items-center">
                  <input type="number" step="0.01" min="0"
                         name="old_price_{{ $p['k'] }}"
                         value="{{ old('old_price_'.$p['k']) }}"
                         class="input-tech sm:max-w-[140px]" placeholder="0.00" data-old-input>

                  <div class="flex items-center gap-2 flex-nowrap text-xs text-white/60 whitespace-nowrap" data-off-preview hidden>
                    <span class="line-through whitespace-nowrap" data-old-display></span>
                    <span data-off-chip class="text-[11px] px-2.5 py-1 rounded-full whitespace-nowrap shrink-0 font-semibold tracking-wide text-amber-100
                                 border border-amber-200/40 bg-gradient-to-r from-amber-200/20 via-yellow-300/20 to-amber-200/20
                                 shadow-[0_0_18px_rgba(250,204,21,0.25)]">
                      <span data-off-badge></span>% OFF
                    </span>
                  </div>
                </div>

                <label class="text-xs text-white/60 mt-3 block">Precio actual</label>
                <input type="number" step="0.01" min="0"
                       name="price_{{ $p['k'] }}"
                       value="{{ old('price_'.$p['k']) }}"
                       class="input-tech" placeholder="0.00" data-price-input>
              </div>
            @endforeach
          </div>

          {{-- ERRORES --}}
          <div class="mt-3 grid gap-2 text-xs text-red-300">
            @foreach([
              'price_monthly','price_bimestral','price_trimestral','price_semestral','price_anual',
              'old_price_monthly','old_price_bimestral','old_price_trimestral','old_price_semestral','old_price_anual'
            ] as $f)
              @error($f) <div>{{ $message }}</div> @enderror
            @endforeach
          </div>
        </div>
      </div>

      {{-- ORDEN / ACTIVO --}}
      <div class="grid gap-4 sm:grid-cols-2">
        <div>
          <label class="text-sm text-white/80 font-semibold">Orden (0–9999)</label>
          <input type="number" name="sort_order" min="0" max="9999" value="{{ old('sort_order', 0) }}" class="input-tech">
        </div>

        <div class="flex items-center gap-3 pt-7">
          <input id="is_active_new" name="is_active" type="checkbox" class="h-5 w-5 rounded border-white/20 bg-white/5" checked>
          <label for="is_active_new" class="text-white/80 font-semibold">Activo / Visible</label>
        </div>
      </div>

      <div class="flex gap-3 flex-wrap">
        <button class="btn-primary" type="submit">Guardar pack</button>
        <a class="btn-tech" href="{{ route('herramientas') }}" target="_blank" rel="noopener">Ver en la web</a>
      </div>
    </form>
  </div>
</div>

{{-- =========================
   LISTADO / EDITAR PACKS
   ========================= --}}
<div class="mt-10">
  <h3 class="text-2xl font-extrabold">Packs existentes</h3>
  <p class="text-white/60 mt-1 text-sm">Edita rápido, claro y sin confusión.</p>

  <div class="mt-6 grid gap-6">
    @foreach($tools as $tool)
      <div class="neon-frame">
        <div class="neon-inner p-6 md:p-8">
          <div class="flex items-start justify-between gap-4 flex-wrap">
            <div class="min-w-0">
              <p class="text-xs text-white/60 uppercase tracking-widest">Pack</p>
              <h4 class="text-xl font-extrabold truncate">{{ $tool->title }}</h4>
              <p class="text-white/60 text-sm mt-1 line-clamp-2">{{ $tool->subtitle }}</p>
            </div>

            <form method="POST" action="{{ route('admin.tools.destroy', $tool) }}"
                  onsubmit="return confirm('¿Eliminar este pack?')">
              @csrf @method('DELETE')
              <button class="btn-tech" type="submit">Eliminar</button>
            </form>
          </div>

          @php
            $toolMediaVersion = null;
            if ($tool->media_path && \Illuminate\Support\Facades\Storage::disk('public')->exists($tool->media_path)) {
              $toolMediaVersion = \Illuminate\Support\Facades\Storage::disk('public')->lastModified($tool->media_path);
            }
            $toolMediaVersion = $toolMediaVersion ?? ($tool->updated_at?->timestamp ?? time());
            $toolMediaUrl = $tool->media_path
              ? asset('storage/' . $tool->media_path) . '?v=' . $toolMediaVersion
              : null;
            $toolMediaIsVideo = $tool->media_mime && \Illuminate\Support\Str::startsWith($tool->media_mime, 'video/');
          @endphp

          @if($toolMediaUrl)
            <div class="mt-4 rounded-2xl border border-white/10 bg-white/5 p-3">
              <div class="relative min-h-[170px] flex items-center justify-center">
                    @if($toolMediaIsVideo)
                      <video class="media-card__media" src="{{ $toolMediaUrl }}" muted loop playsinline controls></video>
                @else
                  <img class="media-card__media" src="{{ $toolMediaUrl }}" alt="Video del pack">
                @endif
              </div>
            </div>
          @endif

          {{-- MEDIA DEL PACK (FORM independiente) --}}
          <form id="tool-media-{{ $tool->id }}" method="POST" action="{{ route('admin.tools.media', $tool) }}" enctype="multipart/form-data" class="mt-6">
            @csrf
            <div class="neon-frame">
              <div class="neon-inner p-5 md:p-6">
                <h4 class="font-extrabold text-lg">Video del pack (opcional)</h4>
                <p class="text-white/60 text-sm mt-1">Video 3–5s en loop o GIF optimizado.</p>
                @if(session('status') && session('status_media_tool_id') == $tool->id)
                  <div class="mt-3 text-xs font-semibold text-emerald-200 bg-emerald-400/15 border border-emerald-400/40 rounded-lg px-3 py-2 shadow-[0_0_18px_rgba(16,185,129,0.25)]">
                    {{ session('status') }}
                  </div>
                @endif

                @if($toolMediaUrl)
                  <div class="mt-3">
                    <div class="flex items-center justify-between gap-3 mb-2">
                      <p class="text-xs text-white/60">Vista previa actual</p>
                      <button class="btn-tech text-red-200 border-red-400/40 bg-red-500/10 hover:bg-red-500/20"
                              type="submit"
                              form="tool-media-delete-{{ $tool->id }}"
                              onclick="return confirm('¿Eliminar el video actual?')">
                        Eliminar video actual
                      </button>
                    </div>
                    @if($toolMediaIsVideo)
                      <video class="media-card__media max-w-[420px]"
                             src="{{ $toolMediaUrl }}" muted loop playsinline controls></video>
                    @else
                      <img class="media-card__media max-w-[420px]" src="{{ $toolMediaUrl }}" alt="Video del pack">
                    @endif
                    <p class="text-xs text-white/50 mt-2">
                      {{ $tool->media_original_name ?? 'video' }} · {{ $tool->media_mime ?? 'desconocido' }}
                    </p>
                    <p class="text-xs mt-1 {{ $tool->media_active ? 'text-emerald-300' : 'text-white/50' }}">
                      Estado: {{ $tool->media_active ? 'Activo' : 'Desactivado' }}
                    </p>
                  </div>
                @else
                  <p class="text-xs text-white/50 mt-2">Estado: Sin video</p>
                @endif

                <div class="mt-4 grid gap-4 sm:grid-cols-2">
                  <div>
                    <label class="text-sm text-white/80 font-semibold">Reemplazar video actual</label>
                    <input type="file" name="media" accept="video/mp4,video/webm,image/gif" class="input-tech" data-media-validate>
                    <input type="hidden" name="media_selected" value="0" data-media-selected>
                    @error('media') <p class="text-red-300 text-xs mt-1">{{ $message }}</p> @enderror
                    <p class="text-xs text-white/50 mt-1">Recomendado: 3–5s, &lt; 8MB.</p>
                    <p class="text-xs text-white/50 mt-1">Subir un nuevo archivo reemplaza el anterior automáticamente.</p>
                    <p data-media-name class="text-xs text-white/70 mt-1 hidden"></p>
                    <p data-media-msg class="text-xs text-red-300 mt-1 hidden"></p>
                    <div data-media-preview class="mt-3 hidden"></div>
                  </div>

                  <div class="flex items-center gap-3 pt-7">
                    <input type="hidden" name="media_toggle" value="0" data-media-toggle>
                    <input type="hidden" name="media_active" value="0">
                    <input id="media_active_{{ $tool->id }}" name="media_active" type="checkbox"
                           class="h-5 w-5 rounded border-white/20 bg-white/5"
                           {{ old('media_active', $tool->media_active) ? 'checked' : '' }}>
                    <label for="media_active_{{ $tool->id }}" class="text-white/80 font-semibold">Activar video</label>
                  </div>
                </div>

                <div class="mt-4 flex gap-3 flex-wrap">
                  <button class="btn-primary" type="submit" form="tool-media-{{ $tool->id }}">Guardar video</button>
                </div>
              </div>
            </div>
          </form>
          @if($toolMediaUrl)
            <form id="tool-media-delete-{{ $tool->id }}" method="POST" action="{{ route('admin.tools.media.delete', $tool) }}">
              @csrf
              @method('DELETE')
            </form>
          @endif

          <form method="POST" action="{{ route('admin.tools.update', $tool) }}" class="mt-6 grid gap-6">
            @csrf @method('PUT')

            {{-- BÁSICO --}}
            <div class="grid gap-4 lg:grid-cols-3">
              <div class="lg:col-span-2">
                <label class="text-sm text-white/80 font-semibold">Título</label>
                <input name="title" value="{{ old('title', $tool->title) }}" class="input-tech" required>
              </div>

              <div>
                <label class="text-sm text-white/80 font-semibold">Tag</label>
                <input name="tag" value="{{ old('tag', $tool->tag) }}" class="input-tech">
              </div>

              <div class="lg:col-span-2">
                <label class="text-sm text-white/80 font-semibold">Subtítulo</label>
                <input name="subtitle" value="{{ old('subtitle', $tool->subtitle) }}" class="input-tech" required>
              </div>

              <div>
                <label class="text-sm text-white/80 font-semibold">Badge</label>
                <input name="badge_text" value="{{ old('badge_text', $tool->badge_text) }}" class="input-tech">
              </div>

              <div class="lg:col-span-3">
                <label class="text-sm text-white/80 font-semibold">Descripción corta</label>
                <input name="short_desc" value="{{ old('short_desc', $tool->short_desc) }}" class="input-tech">
              </div>
            </div>

            {{-- TEXTO --}}
            <div class="grid gap-4 lg:grid-cols-3">
              <div>
                <label class="text-sm text-white/80 font-semibold">Highlights (1 por línea)</label>
                <textarea name="highlights_text" rows="6" class="input-tech">{{ old('highlights_text', implode("\n", $tool->highlights ?? [])) }}</textarea>
              </div>

              <div>
                <label class="text-sm text-white/80 font-semibold">Incluye (label|texto)</label>
                <textarea name="includes_text" rows="6" class="input-tech">@php
                  $inc = $tool->includes ?? [];
                  echo old('includes_text', collect($inc)->map(fn($r)=>($r['label']??'').'|'.($r['text']??''))->implode("\n"));
                @endphp</textarea>
              </div>

              <div>
                <label class="text-sm text-white/80 font-semibold">Extras (1 por línea)</label>
                <textarea name="extras_text" rows="6" class="input-tech">{{ old('extras_text', implode("\n", $tool->extras ?? [])) }}</textarea>
              </div>

              <div class="lg:col-span-3">
                <label class="text-sm text-white/80 font-semibold">Audiencia</label>
                <input name="audience" value="{{ old('audience', $tool->audience) }}" class="input-tech">
              </div>
            </div>

            {{-- PRECIOS EDIT --}}
            <div class="neon-frame">
              <div class="neon-inner p-5 md:p-6">
                <h4 class="font-extrabold text-lg">Planes por período</h4>
                <p class="text-white/60 text-sm mt-1">Actual + anterior (OFF automático en la web).</p>

                @php
                  $editPlans = [
                    ['k'=>'monthly',    'name'=>'Mensual'],
                    ['k'=>'bimestral',  'name'=>'Bimestral'],
                    ['k'=>'trimestral', 'name'=>'Trimestral'],
                    ['k'=>'semestral',  'name'=>'Semestral'],
                    ['k'=>'anual',      'name'=>'Anual'],
                  ];
                @endphp

                <div class="mt-5 grid gap-4 sm:grid-cols-2 lg:grid-cols-5">
                  @foreach($editPlans as $p)
                    <div class="glass rounded-2xl p-4 border border-white/10" data-off-wrapper>
                      <p class="font-semibold text-white/85 text-sm">{{ $p['name'] }}</p>

                      <label class="text-xs text-white/60 mt-3 block">Precio anterior</label>
                      <div class="mt-2 flex flex-col gap-2 sm:flex-row sm:items-center">
                        <input type="number" step="0.01" min="0"
                               name="old_price_{{ $p['k'] }}"
                               value="{{ old('old_price_'.$p['k'], data_get($tool, 'old_price_'.$p['k'])) }}"
                               class="input-tech sm:max-w-[140px]" data-old-input>

                        <div class="flex items-center gap-2 flex-nowrap text-xs text-white/60 whitespace-nowrap" data-off-preview hidden>
                          <span class="line-through whitespace-nowrap" data-old-display></span>
                          <span data-off-chip class="text-[11px] px-2.5 py-1 rounded-full whitespace-nowrap shrink-0 font-semibold tracking-wide text-amber-100
                                       border border-amber-200/40 bg-gradient-to-r from-amber-200/20 via-yellow-300/20 to-amber-200/20
                                       shadow-[0_0_18px_rgba(250,204,21,0.25)]">
                            <span data-off-badge></span>% OFF
                          </span>
                        </div>
                      </div>

                      <label class="text-xs text-white/60 mt-3 block">Precio actual</label>
                      <input type="number" step="0.01" min="0"
                             name="price_{{ $p['k'] }}"
                             value="{{ old('price_'.$p['k'], data_get($tool, 'price_'.$p['k'])) }}"
                             class="input-tech" data-price-input>
                    </div>
                  @endforeach
                </div>
              </div>
            </div>

            {{-- ORDEN / ACTIVO --}}
            <div class="grid gap-4 sm:grid-cols-2">
              <div>
                <label class="text-sm text-white/80 font-semibold">Orden</label>
                <input type="number" name="sort_order" min="0" max="9999"
                       value="{{ old('sort_order', $tool->sort_order ?? 0) }}"
                       class="input-tech">
              </div>

              <div class="flex items-center gap-3 pt-7">
                <input id="is_active_{{ $tool->id }}" name="is_active" type="checkbox"
                       class="h-5 w-5 rounded border-white/20 bg-white/5"
                       {{ old('is_active', $tool->is_active) ? 'checked' : '' }}>
                <label for="is_active_{{ $tool->id }}" class="text-white/80 font-semibold">Activo / Visible</label>
              </div>
            </div>

            <div class="flex gap-3 flex-wrap">
              <button class="btn-primary" type="submit">Guardar cambios</button>
              <a class="btn-tech" href="{{ route('herramientas', ['tool'=>$tool->id]) }}" target="_blank" rel="noopener">Ver en la web</a>
            </div>
          </form>
        </div>
      </div>
    @endforeach
  </div>
</div>
<script>
  document.addEventListener('DOMContentLoaded', () => {
    const formatMoney = (value) => {
      if (Number.isNaN(value)) return null;
      return new Intl.NumberFormat('es-PE', {
        minimumFractionDigits: 0,
        maximumFractionDigits: 0,
      }).format(value);
    };

    const updatePreview = (wrapper) => {
      const oldInput = wrapper.querySelector('[data-old-input]');
      const priceInput = wrapper.querySelector('[data-price-input]');
      const preview = wrapper.querySelector('[data-off-preview]');
      const oldDisplay = wrapper.querySelector('[data-old-display]');
      const offBadge = wrapper.querySelector('[data-off-badge]');
      const offChip = wrapper.querySelector('[data-off-chip]');

      if (!oldInput || !priceInput || !preview || !oldDisplay || !offBadge) return;

      const oldValue = parseFloat(oldInput.value);
      const priceValue = parseFloat(priceInput.value);
      const hasOld = !Number.isNaN(oldValue) && oldValue > 0;
      const hasPrice = !Number.isNaN(priceValue) && priceValue > 0;
      const off = hasOld && hasPrice && oldValue > priceValue
        ? Math.round(((oldValue - priceValue) / oldValue) * 100)
        : null;

      if (hasOld) {
        oldDisplay.textContent = `S/. ${formatMoney(oldValue)}`;
        preview.hidden = false;
        preview.removeAttribute('hidden');
        preview.style.display = 'flex';

        if (off && offChip) {
          offBadge.textContent = off;
          offChip.hidden = false;
        } else if (offChip) {
          offChip.hidden = true;
        }
      } else {
        preview.hidden = true;
        preview.style.display = 'none';
      }
    };

    document.querySelectorAll('[data-off-wrapper]').forEach((wrapper) => {
      const oldInput = wrapper.querySelector('[data-old-input]');
      const priceInput = wrapper.querySelector('[data-price-input]');
      const handler = () => updatePreview(wrapper);

      oldInput?.addEventListener('input', handler);
      priceInput?.addEventListener('input', handler);
      updatePreview(wrapper);
    });

    const validateMedia = (input) => {
      const wrapper = input.closest('div');
      const msg = wrapper?.querySelector('[data-media-msg]');
      const nameEl = wrapper?.querySelector('[data-media-name]');
      const previewEl = wrapper?.querySelector('[data-media-preview]');
      const form = input.closest('form');
      const submitBtn = form?.querySelector('button[type=\"submit\"]');
      const selectedInput = form?.querySelector('[data-media-selected]');

      if (msg) {
        msg.classList.add('hidden');
        msg.textContent = '';
      }
      if (nameEl) {
        nameEl.classList.add('hidden');
        nameEl.textContent = '';
      }
      if (previewEl) {
        previewEl.classList.add('hidden');
        previewEl.innerHTML = '';
      }
      if (submitBtn) submitBtn.disabled = false;

      const file = input.files && input.files[0];
      if (!file) return;
      if (selectedInput) selectedInput.value = '1';

      const allowedTypes = ['video/mp4', 'video/webm', 'image/gif'];
      if (!allowedTypes.includes(file.type)) {
        if (msg) {
          msg.textContent = 'Formato no permitido. Usa MP4, WebM o GIF.';
          msg.classList.remove('hidden');
        }
        if (submitBtn) submitBtn.disabled = true;
        return;
      }

      if (nameEl) {
        nameEl.textContent = `Archivo seleccionado: ${file.name}`;
        nameEl.classList.remove('hidden');
      }

      if (previewEl) {
        const objectUrl = URL.createObjectURL(file);
        if (file.type.startsWith('video/')) {
          previewEl.innerHTML = `<video class="media-card__media max-w-[420px]" muted loop playsinline controls src="${objectUrl}"></video>`;
        } else {
          previewEl.innerHTML = `<img class="media-card__media max-w-[420px]" src="${objectUrl}" alt="Preview">`;
        }
        previewEl.classList.remove('hidden');
      }

      const maxBytes = 8 * 1024 * 1024;
      if (file.size > maxBytes) {
        if (msg) {
          msg.textContent = 'El archivo supera 8MB. Optimiza el video o reduce su peso.';
          msg.classList.remove('hidden');
        }
        if (submitBtn) submitBtn.disabled = true;
        return;
      }

      if (file.type.startsWith('video/')) {
        const video = document.createElement('video');
        video.preload = 'metadata';
        video.src = URL.createObjectURL(file);
        video.onloadedmetadata = () => {
          URL.revokeObjectURL(video.src);
          const d = video.duration || 0;
          if (d < 3 || d > 5) {
            if (msg) {
              msg.textContent = 'El video debe durar entre 3 y 5 segundos.';
              msg.classList.remove('hidden');
            }
            if (submitBtn) submitBtn.disabled = true;
          }
        };
      }
    };

    document.querySelectorAll('[data-media-validate]').forEach((input) => {
      input.addEventListener('change', () => validateMedia(input));
    });

    document.querySelectorAll('input[name="media_active"]').forEach((toggle) => {
      toggle.addEventListener('change', () => {
        const form = toggle.closest('form');
        const toggleInput = form?.querySelector('[data-media-toggle]');
        if (toggleInput) toggleInput.value = '1';
      });
    });
  });
</script>
@endsection
