<?php $__env->startSection('title', 'FAQ · GVelarde'); ?>

<?php $__env->startSection('content'); ?>
<h2 class="text-3xl font-extrabold">Preguntas frecuentes</h2>
<p class="text-white/70 mt-2">Respuestas directas.</p>

<div class="mt-8 grid gap-4">
<?php $__currentLoopData = [
  [
    'q' => '¿Qué tipo de inteligencias artificiales ofrece la plataforma?',
    'a' => 'La plataforma ofrece acceso a diversas herramientas de inteligencia artificial orientadas a productividad, automatización y creación de contenido, según disponibilidad.'
  ],
  [
    'q' => '¿Las inteligencias artificiales son originales?',
    'a' => 'Se brindan accesos funcionales y verificados. Las características pueden variar de acuerdo con la herramienta y el plan contratado.'
  ],
  [
    'q' => '¿Las cuentas son permanentes?',
    'a' => 'El acceso se otorga por el período establecido en el plan adquirido. La vigencia depende del tipo de servicio contratado.'
  ],
  [
    'q' => '¿El uso es ilimitado?',
    'a' => 'Las condiciones de uso dependen de cada herramienta y del tipo de acceso disponible. Pueden existir límites operativos.'
  ],
  [
    'q' => '¿Necesito conocimientos técnicos para usarlas?',
    'a' => 'No. La plataforma está diseñada para ser utilizada de forma sencilla por cualquier tipo de usuario.'
  ],
  [
    'q' => '¿Cada usuario tiene su propio panel?',
    'a' => 'Sí. Cada cliente dispone de un panel donde puede consultar el estado de su acceso y la información relevante del servicio.'
  ],
  [
    'q' => '¿La plataforma cuenta con soporte?',
    'a' => 'Se brinda soporte básico para incidencias generales y orientación sobre el uso de la plataforma.'
  ],
]; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $f): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
  <div class="glass rounded-2xl p-5 card-hover">
      <p class="font-semibold"><?php echo e($f['q']); ?></p>
      <p class="text-white/70 mt-2"><?php echo e($f['a']); ?></p>
  </div>
<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.marketing', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\pagina-ia\resources\views/pages/faq.blade.php ENDPATH**/ ?>