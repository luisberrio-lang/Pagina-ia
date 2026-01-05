
<?php $__env->startSection('title', 'Precios · Pagina-IA'); ?>

<?php $__env->startSection('content'); ?>
<h2 class="text-3xl font-extrabold">Precios</h2>
<p class="text-white/70 mt-2">Planes y detalles por herramienta.</p>

<div class="mt-8 grid gap-5 md:grid-cols-2">
<?php $__empty_1 = true; $__currentLoopData = $tools; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $tool): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
  <div id="tool-<?php echo e($tool->id); ?>" class="glass rounded-3xl p-6">
      <div class="text-xs text-white/70"><?php echo e($tool->tag ?? 'IA'); ?></div>
      <div class="text-2xl font-bold mt-1"><?php echo e($tool->title); ?></div>
      <div class="text-white/70 mt-2"><?php echo e($tool->subtitle); ?></div>

      <div class="mt-4 text-white font-bold text-xl">
        <?php echo e($tool->price ?? 'Consultar'); ?>

      </div>

      <?php if($tool->details): ?>
        <div class="mt-3 text-white/70 whitespace-pre-line"><?php echo e($tool->details); ?></div>
      <?php endif; ?>

      <div class="mt-5 flex gap-3">
        <a class="btn-primary" href="<?php echo e(route('soporte')); ?>">Contratar</a>
        <a class="btn-tech" href="<?php echo e(route('herramientas')); ?>">Volver</a>
      </div>
  </div>
<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
  <div class="glass rounded-3xl p-8 text-white/70">
    Aún no hay planes creados.
  </div>
<?php endif; ?>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.marketing', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Pagina-ia\resources\views/pages/precio.blade.php ENDPATH**/ ?>