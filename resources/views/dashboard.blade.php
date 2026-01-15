@extends('layouts.marketing')
@section('title', 'Admin Dashboard · GVelarde')

@section('content')
<div class="flex items-end justify-between gap-4 flex-wrap">
  <div>
    <h2 class="text-3xl font-extrabold">Dashboard Administrador</h2>
    <p class="text-white/70 mt-2">Crea y edita packs con planes por período y descuentos automáticos.</p>
  </div>

  @if(session('status'))
    <div class="text-sm px-4 py-2 rounded-xl bg-white/5 border border-white/10 text-white/80">
      {{ session('status') }}
    </div>
  @endif
</div>

{{-- =========================
   CREAR NUEVO PACK
   ========================= --}}
<div class="mt-8 neon-frame">
  <div class="neon-inner p-6 md:p-8">
    <h3 class="text-xl font-extrabold">Crear nuevo pack</h3>
    <p class="text-white/60 mt-1 text-sm">Todo organizado por secciones (claro y profesional).</p>

    <form method="POST" action="{{ route('admin.tools.store') }}" class="mt-6 grid gap-6">
      @csrf

      {{-- BLOQUE 1: INFO BÁSICA --}}
      <div class="grid gap-4 lg:grid-cols-3">
        <div class="lg:col-span-2">
          <label class="text-sm text-white/80 font-semibold">Título</label>
          <input name="title" value="{{ old('title') }}" class="input-tech"
                 placeholder="Ej: Pack Edición IA / Pack Diseño IA" required>
          @error('title') <p class="text-red-300 text-xs mt-1">{{ $message }}</p> @enderror
        </div>

        <div>
          <label class="text-sm text-white/80 font-semibold">Etiqueta (opcional)</label>
          <input name="tag" value="{{ old('tag') }}" class="input-tech"
                 placeholder="PACK / VIDEO / DISEÑO / MARKETING">
          @error('tag') <p class="text-red-300 text-xs mt-1">{{ $message }}</p> @enderror
        </div>

        <div class="lg:col-span-2">
          <label class="text-sm text-white/80 font-semibold">Subtítulo</label>
          <input name="subtitle" value="{{ old('subtitle') }}" class="input-tech"
                 placeholder="Breve descripción visible en la tarjeta" required>
          @error('subtitle') <p class="text-red-300 text-xs mt-1">{{ $message }}</p> @enderror
        </div>

        <div>
          <label class="text-sm text-white/80 font-semibold">Sello (opcional)</label>
          <input name="badge_text" value="{{ old('badge_text') }}" class="input-tech"
                 placeholder="Más vendido / Nuevo / Recomendado">
          @error('badge_text') <p class="text-red-300 text-xs mt-1">{{ $message }}</p> @enderror
        </div>

        <div class="lg:col-span-3">
          <label class="text-sm text-white/80 font-semibold">Descripción corta (opcional)</label>
          <input name="short_desc" value="{{ old('short_desc') }}" class="input-tech"
                 placeholder="Texto breve para el panel grande de herramientas">
          @error('short_desc') <p class="text-red-300 text-xs mt-1">{{ $message }}</p> @enderror
        </div>
      </div>

      {{-- BLOQUE 2: CONTENIDO --}}
      <div class="grid gap-4 lg:grid-cols-3">
        <div class="lg:col-span-1">
          <label class="text-sm text-white/80 font-semibold">Puntos clave (1 por línea)</label>
          <textarea name="highlights_text" rows="6" class="input-tech"
                    placeholder="Ej:
Acceso inmediato
Entrega organizada
Soporte básico">{{ old('highlights_text') }}</textarea>
          @error('highlights_text') <p class="text-red-300 text-xs mt-1">{{ $message }}</p> @enderror
        </div>

        <div class="lg:col-span-1">
          <label class="text-sm text-white/80 font-semibold">Incluye (Etiqueta|Detalle por línea)</label>
          <textarea name="includes_text" rows="6" class="input-tech"
                    placeholder="Ej:
Herramientas|Acceso completo
Plantillas|Archivos listos para usar
Soporte|Orientación básica">{{ old('includes_text') }}</textarea>
          @error('includes_text') <p class="text-red-300 text-xs mt-1">{{ $message }}</p> @enderror
        </div>

        <div class="lg:col-span-1">
          <label class="text-sm text-white/80 font-semibold">Extras (1 por línea)</label>
          <textarea name="extras_text" rows="6" class="input-tech"
                    placeholder="Ej:
Bonos
Plantillas
Recursos adicionales">{{ old('extras_text') }}</textarea>
          @error('extras_text') <p class="text-red-300 text-xs mt-1">{{ $message }}</p> @enderror
        </div>

        <div class="lg:col-span-3">
          <label class="text-sm text-white/80 font-semibold">¿Para quién es? (opcional)</label>
          <input name="audience" value="{{ old('audience') }}" class="input-tech"
                 placeholder="Ej: Ideal para creadores, marketers, emprendedores...">
          @error('audience') <p class="text-red-300 text-xs mt-1">{{ $message }}</p> @enderror
        </div>
      </div>

      {{-- BLOQUE 3: PRECIOS --}}
      <div class="neon-frame">
        <div class="neon-inner p-5 md:p-6">
          <div class="flex items-center justify-between gap-3 flex-wrap">
            <div>
              <h4 class="font-extrabold text-lg">Planes por período</h4>
              <p class="text-white/60 text-sm mt-1">
                Ingrese <b>Precio actual</b> y opcionalmente <b>Precio anterior</b>.
                El <b>% OFF se calcula solo</b>.
              </p>
            </div>
            <span class="text-xs px-3 py-2 rounded-full bg-white/5 border border-white/10 text-white/70">
              Descuento automático
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
                <p class="font-semibold text-white/90 text-sm">{{ $p['name'] }}</p>

                <label class="text-xs text-white/60 mt-3 block">Precio anterior (opcional)</label>
                <div class="mt-2 flex flex-col gap-2 sm:flex-row sm:items-center">
                  <input type="number" step="0.01" min="0"
                         name="old_price_{{ $p['k'] }}"
                         value="{{ old('old_price_'.$p['k']) }}"
                         class="input-tech sm:max-w-[140px]"
                         placeholder="Ej: 33.00" data-old-input>

                  <div class="flex items-center gap-2 flex-nowrap text-xs text-white/60 whitespace-nowrap" data-off-preview hidden>
                    <span class="line-through whitespace-nowrap" data-old-display></span>
                    <span class="text-[11px] px-2.5 py-1 rounded-full whitespace-nowrap shrink-0 font-semibold tracking-wide text-amber-100
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
                       class="input-tech"
                       placeholder="Ej: 13.00" data-price-input>
              </div>
            @endforeach
          </div>
        </div>
      </div>

      {{-- BLOQUE 4: ORDEN / ACTIVO --}}
      <div class="grid gap-4 sm:grid-cols-2">
        <div>
          <label class="text-sm text-white/80 font-semibold">Orden (0–9999)</label>
          <input type="number" name="sort_order" min="0" max="9999"
                 value="{{ old('sort_order', 0) }}" class="input-tech">
          @error('sort_order') <p class="text-red-300 text-xs mt-1">{{ $message }}</p> @enderror
        </div>

        <div class="flex items-center gap-3 pt-7">
          <input id="is_active_new" name="is_active" type="checkbox"
                 class="h-5 w-5 rounded border-white/20 bg-white/5" checked>
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
  <p class="text-white/60 mt-1 text-sm">Edita rápido y sin confusión.</p>

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

          <form method="POST" action="{{ route('admin.tools.update', $tool) }}" class="mt-6 grid gap-6">
            @csrf @method('PUT')

            <div class="grid gap-4 lg:grid-cols-3">
              <div class="lg:col-span-2">
                <label class="text-sm text-white/80 font-semibold">Título</label>
                <input name="title" value="{{ old('title', $tool->title) }}" class="input-tech" required>
              </div>

              <div>
                <label class="text-sm text-white/80 font-semibold">Etiqueta</label>
                <input name="tag" value="{{ old('tag', $tool->tag) }}" class="input-tech"
                       placeholder="PACK / VIDEO / DISEÑO / MARKETING">
              </div>

              <div class="lg:col-span-2">
                <label class="text-sm text-white/80 font-semibold">Subtítulo</label>
                <input name="subtitle" value="{{ old('subtitle', $tool->subtitle) }}" class="input-tech" required>
              </div>

              <div>
                <label class="text-sm text-white/80 font-semibold">Sello</label>
                <input name="badge_text" value="{{ old('badge_text', $tool->badge_text) }}" class="input-tech"
                       placeholder="Más vendido / Nuevo / Recomendado">
              </div>

              <div class="lg:col-span-3">
                <label class="text-sm text-white/80 font-semibold">Descripción corta</label>
                <input name="short_desc" value="{{ old('short_desc', $tool->short_desc) }}" class="input-tech"
                       placeholder="Texto breve para el panel grande">
              </div>
            </div>

            <div class="grid gap-4 lg:grid-cols-3">
              <div>
                <label class="text-sm text-white/80 font-semibold">Puntos clave (1 por línea)</label>
                <textarea name="highlights_text" rows="6" class="input-tech"
                          placeholder="Ej:
Acceso inmediato
Entrega organizada
Soporte básico">{{ old('highlights_text', implode("\n", $tool->highlights ?? [])) }}</textarea>
              </div>

              <div>
                <label class="text-sm text-white/80 font-semibold">Incluye (Etiqueta|Detalle)</label>
                <textarea name="includes_text" rows="6" class="input-tech"
                          placeholder="Ej:
Herramientas|Acceso completo
Plantillas|Archivos listos para usar">@php
                  $inc = $tool->includes ?? [];
                  echo old('includes_text', collect($inc)->map(fn($r)=>($r['label']??'').'|'.($r['text']??''))->implode("\n"));
                @endphp</textarea>
              </div>

              <div>
                <label class="text-sm text-white/80 font-semibold">Extras (1 por línea)</label>
                <textarea name="extras_text" rows="6" class="input-tech"
                          placeholder="Ej:
Bonos
Plantillas
Recursos adicionales">{{ old('extras_text', implode("\n", $tool->extras ?? [])) }}</textarea>
              </div>

              <div class="lg:col-span-3">
                <label class="text-sm text-white/80 font-semibold">¿Para quién es?</label>
                <input name="audience" value="{{ old('audience', $tool->audience) }}" class="input-tech"
                       placeholder="Ej: Ideal para creadores, marketers, emprendedores...">
              </div>
            </div>

            {{-- PRECIOS --}}
            <div class="neon-frame">
              <div class="neon-inner p-5 md:p-6">
                <h4 class="font-extrabold text-lg">Planes por período</h4>
                <p class="text-white/60 text-sm mt-1">
                  Precio anterior + precio actual. El descuento se calcula automáticamente.
                </p>

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
                      <p class="font-semibold text-white/90 text-sm">{{ $p['name'] }}</p>

                      <label class="text-xs text-white/60 mt-3 block">Precio anterior (opcional)</label>
                      <div class="mt-2 flex flex-col gap-2 sm:flex-row sm:items-center">
                        <input type="number" step="0.01" min="0"
                               name="old_price_{{ $p['k'] }}"
                               value="{{ old('old_price_'.$p['k'], data_get($tool, 'old_price_'.$p['k'])) }}"
                               class="input-tech sm:max-w-[140px]"
                               placeholder="Ej: 33.00" data-old-input>

                        <div class="flex items-center gap-2 flex-nowrap text-xs text-white/60 whitespace-nowrap" data-off-preview hidden>
                          <span class="line-through whitespace-nowrap" data-old-display></span>
                          <span class="text-[11px] px-2.5 py-1 rounded-full whitespace-nowrap shrink-0 font-semibold tracking-wide text-amber-100
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
                             class="input-tech"
                             placeholder="Ej: 13.00" data-price-input>
                    </div>
                  @endforeach
                </div>
              </div>
            </div>

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
              <a class="btn-tech" href="{{ route('herramientas', ['tool'=>$tool->id]) }}" target="_blank" rel="noopener">
                Ver en la web
              </a>
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

      if (!oldInput || !priceInput || !preview || !oldDisplay || !offBadge) return;

      const oldValue = parseFloat(oldInput.value);
      const priceValue = parseFloat(priceInput.value);
      const hasOld = !Number.isNaN(oldValue) && oldValue > 0;
      const hasPrice = !Number.isNaN(priceValue) && priceValue > 0;
      const off = hasOld && hasPrice && oldValue > priceValue
        ? Math.round(((oldValue - priceValue) / oldValue) * 100)
        : null;

      if (hasOld && off) {
        oldDisplay.textContent = `S/. ${formatMoney(oldValue)}`;
        offBadge.textContent = off;
        preview.hidden = false;
      } else {
        preview.hidden = true;
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
  });
</script>
@endsection
