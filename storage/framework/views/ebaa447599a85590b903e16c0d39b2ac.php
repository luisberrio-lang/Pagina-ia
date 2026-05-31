<?php $__env->startSection('title', 'Admin Dashboard · GVelarde'); ?>

<?php $__env->startSection('content'); ?>
<div class="flex items-end justify-between gap-4 flex-wrap">
  <div>
    <h2 class="text-3xl font-extrabold">Dashboard Administrador</h2>
    <p class="text-white/70 mt-2">Crea y edita packs con precios por período + precio anterior (OFF automático).</p>
  </div>

</div>

<?php if(session('flash_success') || session('flash_warning') || $errors->any()): ?>
  <div class="mt-5 grid gap-3">
    <?php if(session('flash_success')): ?>
      <div class="rounded-xl border border-emerald-400/40 bg-emerald-400/10 px-4 py-3 text-sm text-emerald-100">
        <?php $__currentLoopData = (array) session('flash_success'); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $message): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
          <p><?php echo e($message); ?></p>
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
      </div>
    <?php elseif(session('status')): ?>
      <div class="rounded-xl border border-emerald-400/40 bg-emerald-400/10 px-4 py-3 text-sm text-emerald-100">
        <p><?php echo e(session('status')); ?></p>
      </div>
    <?php endif; ?>

    <?php if(session('flash_warning')): ?>
      <div class="rounded-xl border border-amber-300/40 bg-amber-300/10 px-4 py-3 text-sm text-amber-100">
        <?php $__currentLoopData = (array) session('flash_warning'); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $message): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
          <p><?php echo e($message); ?></p>
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
      </div>
    <?php endif; ?>

    <?php if($errors->any()): ?>
      <div class="rounded-xl border border-red-400/40 bg-red-500/10 px-4 py-3 text-sm text-red-100">
        <p class="font-semibold">No se pudo completar la acción.</p>
        <?php $__currentLoopData = $errors->all(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $message): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
          <p class="mt-1"><?php echo e($message); ?></p>
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
      </div>
    <?php endif; ?>
  </div>
<?php elseif(session('status')): ?>
  <div class="mt-5 rounded-xl border border-emerald-400/40 bg-emerald-400/10 px-4 py-3 text-sm text-emerald-100">
    <p><?php echo e(session('status')); ?></p>
  </div>
<?php endif; ?>

<?php
  $uploadMax = ini_get('upload_max_filesize');
  $postMax = ini_get('post_max_size');
?>

<div class="mt-4 text-xs text-white/60">
  Límite de subida (PHP): <span class="text-white/80"><?php echo e($uploadMax); ?></span> ·
  POST máx: <span class="text-white/80"><?php echo e($postMax); ?></span>
</div>


<div class="mt-8 neon-frame">
  <div class="neon-inner p-6 md:p-8">
    <h3 class="text-xl font-extrabold">Crear nuevo pack</h3>
    <p class="text-white/60 mt-1 text-sm">Todo organizado por secciones.</p>

    <form method="POST" action="<?php echo e(route('admin.tools.store')); ?>" enctype="multipart/form-data" class="mt-6 grid gap-6">
      <?php echo csrf_field(); ?>

      
      <div class="grid gap-4 lg:grid-cols-3">
        <div class="lg:col-span-2">
          <label class="text-sm text-white/80 font-semibold">Título</label>
          <input name="title" value="<?php echo e(old('title')); ?>" class="input-tech" required>
          <?php $__errorArgs = ['title'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> <p class="text-red-300 text-xs mt-1"><?php echo e($message); ?></p> <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
        </div>

        <div>
          <label class="text-sm text-white/80 font-semibold">Tag (opcional)</label>
          <input name="tag" value="<?php echo e(old('tag')); ?>" class="input-tech" placeholder="PACK / VIDEO / IA">
          <?php $__errorArgs = ['tag'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> <p class="text-red-300 text-xs mt-1"><?php echo e($message); ?></p> <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
        </div>

        <div class="lg:col-span-2">
          <label class="text-sm text-white/80 font-semibold">Subtítulo</label>
          <input name="subtitle" value="<?php echo e(old('subtitle')); ?>" class="input-tech" required>
          <?php $__errorArgs = ['subtitle'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> <p class="text-red-300 text-xs mt-1"><?php echo e($message); ?></p> <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
        </div>

        <div>
          <label class="text-sm text-white/80 font-semibold">Badge (opcional)</label>
          <input name="badge_text" value="<?php echo e(old('badge_text')); ?>" class="input-tech" placeholder="Más vendido / Nuevo">
          <?php $__errorArgs = ['badge_text'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> <p class="text-red-300 text-xs mt-1"><?php echo e($message); ?></p> <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
        </div>

        <div class="lg:col-span-3">
          <label class="text-sm text-white/80 font-semibold">Descripción corta (opcional)</label>
          <input name="short_desc" value="<?php echo e(old('short_desc')); ?>" class="input-tech">
          <?php $__errorArgs = ['short_desc'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> <p class="text-red-300 text-xs mt-1"><?php echo e($message); ?></p> <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
        </div>
      </div>

      
      <div class="grid gap-4 lg:grid-cols-3">
        <div>
          <label class="text-sm text-white/80 font-semibold">Highlights (1 por línea)</label>
          <textarea name="highlights_text" rows="6" class="input-tech"><?php echo e(old('highlights_text')); ?></textarea>
        </div>

        <div>
          <label class="text-sm text-white/80 font-semibold">Incluye (label|texto por línea)</label>
          <textarea name="includes_text" rows="6" class="input-tech"><?php echo e(old('includes_text')); ?></textarea>
        </div>

        <div>
          <label class="text-sm text-white/80 font-semibold">Extras (1 por línea)</label>
          <textarea name="extras_text" rows="6" class="input-tech"><?php echo e(old('extras_text')); ?></textarea>
        </div>

        <div class="lg:col-span-3">
          <label class="text-sm text-white/80 font-semibold">Audiencia (opcional)</label>
          <input name="audience" value="<?php echo e(old('audience')); ?>" class="input-tech">
        </div>
      </div>

      
      <div class="neon-frame">
        <div class="neon-inner p-5 md:p-6" data-currency-section>
          <h4 class="font-extrabold text-lg">Media del pack (opcional)</h4>
          <p class="text-white/60 text-sm mt-1">
            Imagen optimizada o video corto para web (3 a 30s).
          </p>
          <p class="text-xs text-amber-200 mt-2">
            Modo compatible: los videos se guardarán sin compresión. Usa MP4 H.264 o WebM optimizado para mejor velocidad.
          </p>

          <div class="mt-4 grid gap-4 sm:grid-cols-2">
            <div>
              <label class="text-sm text-white/80 font-semibold">Archivo (JPG/PNG/WebP/GIF/MP4/WebM)</label>
              <input type="file" name="media" accept="image/jpeg,image/png,image/webp,image/gif,video/mp4,video/webm" class="input-tech" data-media-validate>
              <input type="hidden" name="media_selected" value="0" data-media-selected>
              <?php $__errorArgs = ['media'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> <p class="text-red-300 text-xs mt-1"><?php echo e($message); ?></p> <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
              <p class="text-xs text-white/50 mt-1">Máximo 40MB. Videos: 3 a 30s, ideal MP4 H.264 optimizado.</p>
              <p data-media-name class="text-xs text-white/70 mt-1 hidden"></p>
              <p data-media-msg class="text-xs text-red-300 mt-1 hidden"></p>
              <div data-media-preview class="mt-3 hidden"></div>
            </div>

            <div class="flex items-center gap-3 pt-7">
              <input type="hidden" name="media_toggle" value="0" data-media-toggle>
              <input type="hidden" name="media_active" value="0">
              <input id="media_active_new" name="media_active" type="checkbox" value="1"
                     class="h-5 w-5 rounded border-white/20 bg-white/5">
              <label for="media_active_new" class="text-white/80 font-semibold">Activar multimedia</label>
            </div>
          </div>
        </div>
      </div>

      
      <div class="neon-frame">
        <div class="neon-inner p-5 md:p-6" data-currency-section>
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

          <?php $createCurrency = old('currency', 'PEN'); ?>
          <div class="mt-5 max-w-xs">
            <label class="text-xs text-white/60 block">Moneda</label>
            <select name="currency" class="input-tech mt-2" data-currency-select>
              <option value="PEN" <?php echo e($createCurrency === 'PEN' ? 'selected' : ''); ?>>Soles (S/)</option>
              <option value="USD" <?php echo e($createCurrency === 'USD' ? 'selected' : ''); ?>>Dolares ($)</option>
            </select>
            <?php $__errorArgs = ['currency'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> <p class="text-red-300 text-xs mt-1"><?php echo e($message); ?></p> <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
          </div>

          <?php
            $planFields = [
              ['k'=>'monthly',    'name'=>'Mensual'],
              ['k'=>'bimestral',  'name'=>'Bimestral'],
              ['k'=>'trimestral', 'name'=>'Trimestral'],
              ['k'=>'semestral',  'name'=>'Semestral'],
              ['k'=>'anual',      'name'=>'Anual'],
            ];
          ?>

          <div class="mt-5 grid gap-4 sm:grid-cols-2 lg:grid-cols-5">
            <?php $__currentLoopData = $planFields; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $p): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
              <div class="glass rounded-2xl p-4 border border-white/10" data-off-wrapper>
                <p class="font-semibold text-white/85 text-sm"><?php echo e($p['name']); ?></p>

                <label class="text-xs text-white/60 mt-3 block">Precio anterior (tachado)</label>
                <div class="mt-2 flex flex-col gap-2 sm:flex-row sm:items-center">
                  <input type="number" step="0.01" min="0"
                         name="old_price_<?php echo e($p['k']); ?>"
                         value="<?php echo e(old('old_price_'.$p['k'])); ?>"
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
                       name="price_<?php echo e($p['k']); ?>"
                       value="<?php echo e(old('price_'.$p['k'])); ?>"
                       class="input-tech" placeholder="0.00" data-price-input>
              </div>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
          </div>

          
          <div class="mt-3 grid gap-2 text-xs text-red-300">
            <?php $__currentLoopData = [
              'price_monthly','price_bimestral','price_trimestral','price_semestral','price_anual',
              'old_price_monthly','old_price_bimestral','old_price_trimestral','old_price_semestral','old_price_anual'
            ]; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $f): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
              <?php $__errorArgs = [$f];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> <div><?php echo e($message); ?></div> <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
          </div>
        </div>
      </div>

      
      <div class="grid gap-4 sm:grid-cols-2">
        <div>
          <label class="text-sm text-white/80 font-semibold">Orden (0–9999)</label>
          <input type="number" name="sort_order" min="0" max="9999" value="<?php echo e(old('sort_order', 0)); ?>" class="input-tech">
        </div>

        <div class="flex items-center gap-3 pt-7">
          <input id="is_active_new" name="is_active" type="checkbox" class="h-5 w-5 rounded border-white/20 bg-white/5" checked>
          <label for="is_active_new" class="text-white/80 font-semibold">Activo / Visible</label>
        </div>
      </div>

      <div class="flex gap-3 flex-wrap">
        <button class="btn-primary" type="submit">Guardar pack</button>
        <a class="btn-tech" href="<?php echo e(route('herramientas')); ?>" target="_blank" rel="noopener">Ver en la web</a>
      </div>
    </form>
  </div>
</div>


<div class="mt-10">
  <h3 class="text-2xl font-extrabold">Packs existentes</h3>
  <p class="text-white/60 mt-1 text-sm">Edita rápido, claro y sin confusión.</p>

  <div class="mt-6 grid gap-6">
    <?php $__currentLoopData = $tools; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $tool): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
      <div class="neon-frame">
        <div class="neon-inner p-6 md:p-8">
          <div class="flex items-start justify-between gap-4 flex-wrap">
            <div class="min-w-0">
              <p class="text-xs text-white/60 uppercase tracking-widest">Pack</p>
              <h4 class="text-xl font-extrabold truncate"><?php echo e($tool->title); ?></h4>
              <p class="text-white/60 text-sm mt-1 line-clamp-2"><?php echo e($tool->subtitle); ?></p>
            </div>

            <form method="POST" action="<?php echo e(route('admin.tools.destroy', $tool)); ?>"
                  onsubmit="return confirm('¿Eliminar este pack?')">
              <?php echo csrf_field(); ?> <?php echo method_field('DELETE'); ?>
              <button class="btn-tech" type="submit">Eliminar</button>
            </form>
          </div>

          <?php
            $toolMediaVersion = null;
            if ($tool->media_path && \Illuminate\Support\Facades\Storage::disk('public')->exists($tool->media_path)) {
              $toolMediaVersion = \Illuminate\Support\Facades\Storage::disk('public')->lastModified($tool->media_path);
            }
            $toolMediaVersion = $toolMediaVersion ?? ($tool->updated_at?->timestamp ?? time());
            $toolMediaUrl = $tool->media_path
              ? asset('storage/' . $tool->media_path) . '?v=' . $toolMediaVersion
              : null;
            $toolMediaIsVideo = $tool->media_mime && \Illuminate\Support\Str::startsWith($tool->media_mime, 'video/');
          ?>

          <?php if($toolMediaUrl): ?>
            <div class="mt-4 rounded-2xl border border-white/10 bg-white/5 p-3">
              <div class="relative min-h-[170px] flex items-center justify-center">
                    <?php if($toolMediaIsVideo): ?>
                      <video class="media-card__media" src="<?php echo e($toolMediaUrl); ?>" muted loop playsinline controls preload="metadata"></video>
                <?php else: ?>
                  <img class="media-card__media" src="<?php echo e($toolMediaUrl); ?>" alt="Media del pack" loading="lazy" decoding="async">
                <?php endif; ?>
              </div>
            </div>
          <?php endif; ?>

          
          <form id="tool-media-<?php echo e($tool->id); ?>" method="POST" action="<?php echo e(route('admin.tools.media', $tool)); ?>" enctype="multipart/form-data" class="mt-6">
            <?php echo csrf_field(); ?>
            <div class="neon-frame">
              <div class="neon-inner p-5 md:p-6" data-currency-section>
                <h4 class="font-extrabold text-lg">Media del pack (opcional)</h4>
                <p class="text-white/60 text-sm mt-1">Imagen optimizada o video web de 3 a 30s.</p>
                <p class="text-xs text-amber-200 mt-2">
                  Modo compatible: los videos se guardarán sin compresión. Usa MP4 H.264 o WebM optimizado para mejor velocidad.
                </p>
                <?php if(session('status') && session('status_media_tool_id') == $tool->id): ?>
                  <div class="mt-3 text-xs font-semibold text-emerald-200 bg-emerald-400/15 border border-emerald-400/40 rounded-lg px-3 py-2 shadow-[0_0_18px_rgba(16,185,129,0.25)]">
                    <?php echo e(session('status')); ?>

                  </div>
                <?php endif; ?>

                <?php if($toolMediaUrl): ?>
                  <div class="mt-3">
                    <div class="flex items-center justify-between gap-3 mb-2">
                      <p class="text-xs text-white/60">Vista previa actual</p>
                      <button class="btn-tech text-red-200 border-red-400/40 bg-red-500/10 hover:bg-red-500/20"
                              type="submit"
                              form="tool-media-delete-<?php echo e($tool->id); ?>"
                              onclick="return confirm('¿Eliminar la media actual?')">
                        Eliminar media actual
                      </button>
                    </div>
                    <?php if($toolMediaIsVideo): ?>
                      <video class="media-card__media max-w-[420px]"
                             src="<?php echo e($toolMediaUrl); ?>" muted loop playsinline controls preload="metadata"></video>
                    <?php else: ?>
                      <img class="media-card__media max-w-[420px]" src="<?php echo e($toolMediaUrl); ?>" alt="Media del pack" loading="lazy" decoding="async">
                    <?php endif; ?>
                    <p class="text-xs text-white/50 mt-2">
                      <?php echo e($tool->media_original_name ?? 'media'); ?> · <?php echo e($tool->media_mime ?? 'desconocido'); ?>

                    </p>
                    <p class="text-xs mt-1 <?php echo e($tool->media_active ? 'text-emerald-300' : 'text-white/50'); ?>">
                      Estado: <?php echo e($tool->media_active ? 'Activo' : 'Desactivado'); ?>

                    </p>
                  </div>
                <?php else: ?>
                  <p class="text-xs text-white/50 mt-2">Estado: Sin media</p>
                <?php endif; ?>

                <div class="mt-4 grid gap-4 sm:grid-cols-2">
                  <div>
                    <label class="text-sm text-white/80 font-semibold">Reemplazar media actual</label>
                    <input type="file" name="media" accept="image/jpeg,image/png,image/webp,image/gif,video/mp4,video/webm" class="input-tech" data-media-validate>
                    <input type="hidden" name="media_selected" value="0" data-media-selected>
                    <?php $__errorArgs = ['media'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> <p class="text-red-300 text-xs mt-1"><?php echo e($message); ?></p> <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                    <p class="text-xs text-white/50 mt-1">Máximo 40MB. Videos: 3 a 30s, ideal MP4 H.264 optimizado.</p>
                    <p class="text-xs text-white/50 mt-1">Subir un nuevo archivo reemplaza el anterior automáticamente.</p>
                    <p data-media-name class="text-xs text-white/70 mt-1 hidden"></p>
                    <p data-media-msg class="text-xs text-red-300 mt-1 hidden"></p>
                    <div data-media-preview class="mt-3 hidden"></div>
                  </div>

                  <div class="flex items-center gap-3 pt-7">
                    <input type="hidden" name="media_toggle" value="0" data-media-toggle>
                    <input type="hidden" name="media_active" value="0">
                    <input id="media_active_<?php echo e($tool->id); ?>" name="media_active" type="checkbox" value="1"
                           class="h-5 w-5 rounded border-white/20 bg-white/5"
                           <?php echo e(old('media_active', $tool->media_active) ? 'checked' : ''); ?>>
                    <label for="media_active_<?php echo e($tool->id); ?>" class="text-white/80 font-semibold">Activar multimedia</label>
                  </div>
                </div>

                <div class="mt-4 flex gap-3 flex-wrap">
                  <button class="btn-primary" type="submit" form="tool-media-<?php echo e($tool->id); ?>">Guardar media</button>
                </div>
              </div>
            </div>
          </form>
          <?php if($toolMediaUrl): ?>
            <form id="tool-media-delete-<?php echo e($tool->id); ?>" method="POST" action="<?php echo e(route('admin.tools.media.delete', $tool)); ?>">
              <?php echo csrf_field(); ?>
              <?php echo method_field('DELETE'); ?>
            </form>
          <?php endif; ?>

          <form id="edit-tool-<?php echo e($tool->id); ?>" method="POST" action="<?php echo e(route('admin.tools.update', $tool)); ?>" class="mt-6 grid gap-6">
            <?php echo csrf_field(); ?> <?php echo method_field('PUT'); ?>

            
            <div class="grid gap-4 lg:grid-cols-3">
              <div class="lg:col-span-2">
                <label class="text-sm text-white/80 font-semibold">Título</label>
                <input name="title" value="<?php echo e(old('title', $tool->title)); ?>" class="input-tech" required>
              </div>

              <div>
                <label class="text-sm text-white/80 font-semibold">Tag</label>
                <input name="tag" value="<?php echo e(old('tag', $tool->tag)); ?>" class="input-tech">
              </div>

              <div class="lg:col-span-2">
                <label class="text-sm text-white/80 font-semibold">Subtítulo</label>
                <input name="subtitle" value="<?php echo e(old('subtitle', $tool->subtitle)); ?>" class="input-tech" required>
              </div>

              <div>
                <label class="text-sm text-white/80 font-semibold">Badge</label>
                <input name="badge_text" value="<?php echo e(old('badge_text', $tool->badge_text)); ?>" class="input-tech">
              </div>

              <div class="lg:col-span-3">
                <label class="text-sm text-white/80 font-semibold">Descripción corta</label>
                <input name="short_desc" value="<?php echo e(old('short_desc', $tool->short_desc)); ?>" class="input-tech">
              </div>
            </div>

            
            <div class="grid gap-4 lg:grid-cols-3">
              <div>
                <label class="text-sm text-white/80 font-semibold">Highlights (1 por línea)</label>
                <textarea name="highlights_text" rows="6" class="input-tech"><?php echo e(old('highlights_text', implode("\n", $tool->highlights ?? []))); ?></textarea>
              </div>

              <div>
                <label class="text-sm text-white/80 font-semibold">Incluye (label|texto)</label>
                <textarea name="includes_text" rows="6" class="input-tech"><?php
                  $inc = $tool->includes ?? [];
                  echo old('includes_text', collect($inc)->map(fn($r)=>($r['label']??'').'|'.($r['text']??''))->implode("\n"));
                ?></textarea>
              </div>

              <div>
                <label class="text-sm text-white/80 font-semibold">Extras (1 por línea)</label>
                <textarea name="extras_text" rows="6" class="input-tech"><?php echo e(old('extras_text', implode("\n", $tool->extras ?? []))); ?></textarea>
              </div>

              <div class="lg:col-span-3">
                <label class="text-sm text-white/80 font-semibold">Audiencia</label>
                <input name="audience" value="<?php echo e(old('audience', $tool->audience)); ?>" class="input-tech">
              </div>
            </div>

            
            <div class="neon-frame">
              <div class="neon-inner p-5 md:p-6" data-currency-section>
                <h4 class="font-extrabold text-lg">Planes por período</h4>
                <p class="text-white/60 text-sm mt-1">Actual + anterior (OFF automático en la web).</p>

                <?php $editCurrency = old('currency', $tool->currency ?? 'PEN'); ?>
                <div class="mt-4 max-w-xs">
                  <label class="text-xs text-white/60 block">Moneda</label>
                  <select name="currency" class="input-tech mt-2" data-currency-select>
                    <option value="PEN" <?php echo e($editCurrency === 'PEN' ? 'selected' : ''); ?>>Soles (S/)</option>
                    <option value="USD" <?php echo e($editCurrency === 'USD' ? 'selected' : ''); ?>>Dolares ($)</option>
                  </select>
                  <?php $__errorArgs = ['currency'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> <p class="text-red-300 text-xs mt-1"><?php echo e($message); ?></p> <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                </div>

                <?php
                  $editPlans = [
                    ['k'=>'monthly',    'name'=>'Mensual'],
                    ['k'=>'bimestral',  'name'=>'Bimestral'],
                    ['k'=>'trimestral', 'name'=>'Trimestral'],
                    ['k'=>'semestral',  'name'=>'Semestral'],
                    ['k'=>'anual',      'name'=>'Anual'],
                  ];
                ?>

                <div class="mt-5 grid gap-4 sm:grid-cols-2 lg:grid-cols-5">
                  <?php $__currentLoopData = $editPlans; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $p): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <div class="glass rounded-2xl p-4 border border-white/10" data-off-wrapper>
                      <p class="font-semibold text-white/85 text-sm"><?php echo e($p['name']); ?></p>

                      <label class="text-xs text-white/60 mt-3 block">Precio anterior</label>
                      <div class="mt-2 flex flex-col gap-2 sm:flex-row sm:items-center">
                        <input type="number" step="0.01" min="0"
                               name="old_price_<?php echo e($p['k']); ?>"
                               value="<?php echo e(old('old_price_'.$p['k'], data_get($tool, 'old_price_'.$p['k']))); ?>"
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
                             name="price_<?php echo e($p['k']); ?>"
                             value="<?php echo e(old('price_'.$p['k'], data_get($tool, 'price_'.$p['k']))); ?>"
                             class="input-tech" data-price-input>
                    </div>
                  <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </div>
              </div>
            </div>

            
            <div class="grid gap-4 sm:grid-cols-2">
              <div>
                <label class="text-sm text-white/80 font-semibold">Orden</label>
                <input type="number" name="sort_order" min="0" max="9999"
                       value="<?php echo e(old('sort_order', $tool->sort_order ?? 0)); ?>"
                       class="input-tech">
              </div>

              <div class="flex items-center gap-3 pt-7">
                <input id="is_active_<?php echo e($tool->id); ?>" name="is_active" type="checkbox"
                       class="h-5 w-5 rounded border-white/20 bg-white/5"
                       <?php echo e(old('is_active', $tool->is_active) ? 'checked' : ''); ?>>
                <label for="is_active_<?php echo e($tool->id); ?>" class="text-white/80 font-semibold">Activo / Visible</label>
              </div>
            </div>

            <div class="flex gap-3 flex-wrap">
              <button class="btn-primary" type="submit">Guardar cambios</button>
              <a class="btn-tech" href="<?php echo e(route('herramientas', ['tool'=>$tool->id])); ?>" target="_blank" rel="noopener">Ver en la web</a>
            </div>
          </form>
        </div>
      </div>
    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
  </div>
</div>


<?php
  $recentTools = $tools
    ->sortByDesc(fn($item) => optional($item->updated_at ?? $item->created_at)->timestamp ?? $item->id)
    ->take(5);
?>

<div class="mt-10 neon-frame">
  <div class="neon-inner p-6 md:p-8">
    <div class="flex items-start justify-between gap-4 flex-wrap">
      <div>
        <h3 class="text-2xl font-extrabold">Resumen reciente</h3>
        <p class="text-white/60 mt-1 text-sm">Últimos packs agregados o actualizados, con estado, multimedia y acciones rápidas.</p>
      </div>
      <span class="text-xs px-3 py-2 rounded-full bg-white/5 border border-white/10 text-white/70">
        <?php echo e($recentTools->count()); ?> registrados
      </span>
    </div>

    <?php if($recentTools->isEmpty()): ?>
      <div class="mt-5 rounded-xl border border-white/10 bg-white/5 px-4 py-5 text-sm text-white/70">
        Aún no hay packs registrados.
      </div>
    <?php else: ?>
      <div class="mt-6 grid gap-4">
        <?php $__currentLoopData = $recentTools; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $summaryTool): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
          <?php
            $summaryMediaVersion = null;
            if ($summaryTool->media_path && \Illuminate\Support\Facades\Storage::disk('public')->exists($summaryTool->media_path)) {
              $summaryMediaVersion = \Illuminate\Support\Facades\Storage::disk('public')->lastModified($summaryTool->media_path);
            }
            $summaryMediaUrl = $summaryTool->media_path
              ? asset('storage/' . $summaryTool->media_path) . '?v=' . ($summaryMediaVersion ?? ($summaryTool->updated_at?->timestamp ?? time()))
              : null;
            $summaryMime = $summaryTool->media_mime ?? '';
            $summaryIsVideo = \Illuminate\Support\Str::startsWith($summaryMime, 'video/');
            $summaryIsGif = $summaryMime === 'image/gif';
            $summaryIsImage = \Illuminate\Support\Str::startsWith($summaryMime, 'image/') && !$summaryIsGif;
            $summaryMediaType = $summaryIsVideo
              ? 'video'
              : ($summaryIsGif ? 'gif' : ($summaryIsImage ? 'imagen' : 'sin media'));
            $summaryDate = $summaryTool->updated_at ?? $summaryTool->created_at;
          ?>

          <div class="rounded-xl border border-white/10 bg-white/[0.04] p-4">
            <div class="grid gap-4 md:grid-cols-[112px_1fr_auto] md:items-center">
              <div class="h-24 w-full md:w-28 rounded-lg overflow-hidden border border-white/10 bg-black/20">
                <?php if($summaryMediaUrl && $summaryIsVideo): ?>
                  <video class="media-card__media rounded-none" src="<?php echo e($summaryMediaUrl); ?>" muted loop playsinline preload="metadata"></video>
                <?php elseif($summaryMediaUrl): ?>
                  <img class="media-card__media rounded-none" src="<?php echo e($summaryMediaUrl); ?>" alt="Vista previa de <?php echo e($summaryTool->title); ?>" loading="lazy" decoding="async">
                <?php else: ?>
                  <div class="h-full w-full flex items-center justify-center text-xs text-white/40 px-3 text-center">
                    Sin media
                  </div>
                <?php endif; ?>
              </div>

              <div class="min-w-0">
                <div class="flex items-center gap-2 flex-wrap">
                  <h4 class="font-extrabold text-lg truncate"><?php echo e($summaryTool->title); ?></h4>
                  <span class="text-[11px] px-2.5 py-1 rounded-full border <?php echo e($summaryTool->is_active ? 'border-emerald-300/40 bg-emerald-400/10 text-emerald-200' : 'border-white/15 bg-white/5 text-white/60'); ?>">
                    <?php echo e($summaryTool->is_active ? 'Publicado' : 'No publicado'); ?>

                  </span>
                </div>

                <div class="mt-2 flex flex-wrap gap-2 text-xs text-white/60">
                  <span>Media: <?php echo e($summaryMediaType); ?></span>
                  <span>·</span>
                  <span><?php echo e($summaryDate ? $summaryDate->format('d/m/Y H:i') : 'Sin fecha'); ?></span>
                </div>

                <p class="mt-2 text-sm <?php echo e($summaryTool->media_active && $summaryTool->media_path ? 'text-emerald-200' : 'text-white/55'); ?>">
                  <?php echo e($summaryTool->media_active && $summaryTool->media_path ? 'Multimedia activo y visible.' : 'Sin multimedia activo.'); ?>

                </p>
              </div>

              <div class="flex gap-2 md:justify-end">
                <a class="btn-tech" href="#edit-tool-<?php echo e($summaryTool->id); ?>">Editar</a>
                <form method="POST" action="<?php echo e(route('admin.tools.destroy', $summaryTool)); ?>"
                      onsubmit="return confirm('¿Eliminar este elemento?')">
                  <?php echo csrf_field(); ?>
                  <?php echo method_field('DELETE'); ?>
                  <button class="btn-tech text-red-200 border-red-400/40 bg-red-500/10 hover:bg-red-500/20" type="submit">
                    Eliminar
                  </button>
                </form>
              </div>
            </div>
          </div>
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
      </div>
    <?php endif; ?>
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
      const currencySymbol = wrapper.dataset.currencySymbol || 'S/';

      if (!oldInput || !priceInput || !preview || !oldDisplay || !offBadge) return;

      const oldValue = parseFloat(oldInput.value);
      const priceValue = parseFloat(priceInput.value);
      const hasOld = !Number.isNaN(oldValue) && oldValue > 0;
      const hasPrice = !Number.isNaN(priceValue) && priceValue > 0;
      const off = hasOld && hasPrice && oldValue > priceValue
        ? Math.round(((oldValue - priceValue) / oldValue) * 100)
        : null;

      if (hasOld) {
        oldDisplay.textContent = `${currencySymbol} ${formatMoney(oldValue)}`;
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

    const syncCurrencySection = (section) => {
      const select = section.querySelector('[data-currency-select]');
      const symbol = select?.value === 'USD' ? '$' : 'S/';

      section.querySelectorAll('[data-off-wrapper]').forEach((wrapper) => {
        wrapper.dataset.currencySymbol = symbol;
        updatePreview(wrapper);
      });
    };

    document.querySelectorAll('[data-currency-section]').forEach((section) => {
      const select = section.querySelector('[data-currency-select]');
      const handler = () => syncCurrencySection(section);

      select?.addEventListener('change', handler);
      section.querySelectorAll('[data-off-wrapper]').forEach((wrapper) => {
        const oldInput = wrapper.querySelector('[data-old-input]');
        const priceInput = wrapper.querySelector('[data-price-input]');
        const previewHandler = () => updatePreview(wrapper);

        oldInput?.addEventListener('input', previewHandler);
        priceInput?.addEventListener('input', previewHandler);
      });
      syncCurrencySection(section);
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
        msg.classList.remove('text-amber-200');
        msg.classList.add('text-red-300');
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

      const allowedTypes = ['image/jpeg', 'image/png', 'image/webp', 'image/gif', 'video/mp4', 'video/webm'];
      if (!allowedTypes.includes(file.type)) {
        if (msg) {
          msg.textContent = 'Formato no permitido. Usa JPG, PNG, WebP, GIF, MP4 o WebM.';
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
          previewEl.innerHTML = `<video class="media-card__media max-w-[420px]" muted loop playsinline controls preload="metadata" src="${objectUrl}"></video>`;
        } else {
          previewEl.innerHTML = `<img class="media-card__media max-w-[420px]" src="${objectUrl}" alt="Preview">`;
        }
        previewEl.classList.remove('hidden');
      }

      const maxBytes = 40 * 1024 * 1024;
      if (file.size > maxBytes) {
        if (msg) {
          msg.textContent = 'El archivo supera 40MB. Comprime el archivo antes de subirlo.';
          msg.classList.remove('hidden');
        }
        if (submitBtn) submitBtn.disabled = true;
        return;
      }

      if (file.type.startsWith('video/')) {
        const video = document.createElement('video');
        let metadataChecked = false;
        const warnMetadataUnavailable = () => {
          if (metadataChecked) return;
          metadataChecked = true;
          URL.revokeObjectURL(video.src);
          if (msg) {
            msg.textContent = 'No se pudo detectar la duración en el navegador. Verifica que el video dure entre 3 y 30 segundos antes de guardarlo.';
            msg.classList.remove('hidden', 'text-red-300');
            msg.classList.add('text-amber-200');
          }
        };
        video.preload = 'metadata';
        video.src = URL.createObjectURL(file);
        video.onloadedmetadata = () => {
          if (metadataChecked) return;
          metadataChecked = true;
          URL.revokeObjectURL(video.src);
          const d = video.duration || 0;
          if (d < 3 || d > 30) {
            if (msg) {
              msg.textContent = 'El video debe durar entre 3 y 30 segundos.';
              msg.classList.remove('text-amber-200');
              msg.classList.add('text-red-300');
              msg.classList.remove('hidden');
            }
            if (submitBtn) submitBtn.disabled = true;
          }
        };
        video.onerror = warnMetadataUnavailable;
        setTimeout(warnMetadataUnavailable, 4000);
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
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.marketing', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\pagina-ia\resources\views/admin/dashboard.blade.php ENDPATH**/ ?>