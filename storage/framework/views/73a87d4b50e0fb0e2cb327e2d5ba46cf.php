
<?php $__env->startSection('title', 'FAQ · Pagina-IA'); ?>

<?php $__env->startSection('content'); ?>
<h2 class="text-3xl font-extrabold">Preguntas frecuentes</h2>
<p class="text-white/70 mt-2">Respuestas directas.</p>

<div class="mt-8 grid gap-4">
<?php $__currentLoopData = [
  ['q'=>'¿Es tienda con pagos?', 'a'=>'No, es un mostrador. Pagos se agregan después.'],
  ['q'=>'¿Admin y cliente?', 'a'=>'Sí. Cada uno tiene su dashboard.'],
  ['q'=>'¿Se guardan tickets?', 'a'=>'Sí, en MySQL, y el admin los ve.'],
  ['q'=>'¿Es seguro?', 'a'=>'Roles protegidos, validación y throttle anti-spam.'],
]; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $f): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
  <div class="glass rounded-2xl p-5 card-hover">
      <p class="font-semibold"><?php echo e($f['q']); ?></p>
      <p class="text-white/70 mt-2"><?php echo e($f['a']); ?></p>
  </div>
<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.marketing', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Pagina-ia\resources\views/pages/faq.blade.php ENDPATH**/ ?>