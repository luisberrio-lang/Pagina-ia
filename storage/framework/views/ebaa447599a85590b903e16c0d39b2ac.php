<?php $__env->startSection('title', 'Admin Dashboard · GVelarde'); ?>

<?php $__env->startSection('content'); ?>
<?php
  $tools = $tools ?? \App\Models\Tool::orderBy('sort_order')->orderByDesc('id')->get();
?>

<div class="flex items-end justify-between gap-4 flex-wrap">
  <div>
    <h2 class="text-3xl font-extrabold">Dashboard Administrador</h2>
    <p class="text-white/70 mt-2">Crea y edita packs con precios por período + precio anterior (OFF automático).</p>
  </div>

  <?php if(session('status')): ?>
    <div class="text-sm px-4 py-2 rounded-xl bg-white/5 border border-white/10 text-white/80">
      <?php echo e(session('status')); ?>

    </div>
  <?php endif; ?>
</div>

<div class="mt-8 neon-frame">
  <div class="neon-inner p-6 md:p-8">
    <h3 class="text-xl font-extrabold">Crear nuevo pack</h3>
    <p class="text-white/60 mt-1 text-sm">Todo organizado por secciones.</p>

    <form method="POST" action="<?php echo e(route('admin.tools.store')); ?>" class="mt-6 grid gap-6">
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
        </div>

        <div class="lg:col-span-2">
          <label class="text-sm text-white/80 font-semibold">Subtítulo</label>
          <input name="subtitle" value="<?php echo e(old('subtitle')); ?>" class="input-tech" required>
        </div>

        <div>
          <label class="text-sm text-white/80 font-semibold">Badge (opcional)</label>
          <input name="badge_text" value="<?php echo e(old('badge_text')); ?>" class="input-tech">
        </div>

        <div class="lg:col-span-3">
          <label class="text-sm text-white/80 font-semibold">Descripción corta (opcional)</label>
          <input name="short_desc" value="<?php echo e(old('short_desc')); ?>" class="input-tech">
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
        <div class="neon-inner p-5 md:p-6">
          <div class="flex items-center justify-between gap-3 flex-wrap">
            <div>
              <h4 class="font-extrabold text-lg">Planes por período</h4>
              <p class="text-white/60 text-sm mt-1">
                Ingresa <b>Precio actual</b>, <b>Precio anterior</b> y el <b>% OFF</b> manual.
              </p>
            </div>
            <span class="text-xs px-3 py-2 rounded-full bg-white/5 border border-white/10 text-white/70">
              OFF manual
            </span>
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

          <div class="mt-5 grid gap-4 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-5">
            <?php $__currentLoopData = $planFields; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $p): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
              <div class="glass rounded-2xl p-4 border border-white/10 min-w-0">
                <p class="font-semibold text-white/85 text-sm leading-tight"><?php echo e($p['name']); ?></p>

                <label class="text-xs text-white/60 mt-3 block leading-tight">Precio actual</label>
                <input type="text" inputmode="decimal"
                       name="price_<?php echo e($p['k']); ?>"
                       value="<?php echo e(old('price_'.$p['k'])); ?>"
                       class="input-tech text-sm py-2">

                <label class="text-xs text-white/60 mt-3 block leading-tight">Precio anterior (tachado)</label>
                <input type="text" inputmode="decimal"
                       name="old_price_<?php echo e($p['k']); ?>"
                       value="<?php echo e(old('old_price_'.$p['k'])); ?>"
                       class="input-tech text-sm py-2">

                <label class="text-xs text-white/60 mt-3 block leading-tight">% OFF (manual)</label>
                <input type="number" min="0" max="100"
                       name="off_<?php echo e($p['k']); ?>"
                       value="<?php echo e(old('off_'.$p['k'])); ?>"
                       class="input-tech text-sm py-2">
              </div>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
          </div>
        </div>
      </div>

      <div class="flex gap-3 flex-wrap">
        <button class="btn-primary" type="submit">Guardar pack</button>
      </div>
    </form>
  </div>
</div>

<div class="mt-10">
  <h3 class="text-2xl font-extrabold">Packs existentes</h3>
  <p class="text-white/60 mt-1 text-sm">Edita rápido, claro y sin confusión.</p>

  <div class="mt-6 grid gap-6">
    <?php $__empty_1 = true; $__currentLoopData = $tools; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $tool): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
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

          <form method="POST" action="<?php echo e(route('admin.tools.update', $tool)); ?>" class="mt-6 grid gap-6">
            <?php echo csrf_field(); ?> <?php echo method_field('PUT'); ?>

            
          </form>
        </div>
      </div>
    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
      <div class="glass rounded-2xl p-6 text-white/70">
        No hay herramientas registradas todavía.
      </div>
    <?php endif; ?>
  </div>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.marketing', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\pagina-ia\resources\views/admin/dashboard.blade.php ENDPATH**/ ?>