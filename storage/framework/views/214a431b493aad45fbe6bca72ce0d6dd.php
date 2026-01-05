
<?php $__env->startSection('title', 'Herramientas IA · Pagina-IA'); ?>

<?php $__env->startSection('content'); ?>
<div class="flex items-end justify-between gap-4 flex-wrap">
    <div>
        <h2 class="text-3xl font-extrabold">Herramientas IA</h2>
        <p class="text-white/70 mt-2">Catálogo claro y ordenado. Efectos suaves al pasar y hacer clic.</p>
    </div>
    <a href="<?php echo e(route('soporte')); ?>" class="btn-tech">Soporte</a>
</div>

<div class="mt-8 grid gap-5 sm:grid-cols-2 lg:grid-cols-3">
    <?php $__empty_1 = true; $__currentLoopData = $tools; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $tool): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
        <div class="glass rounded-3xl p-6 card-hover group">
            <div class="flex items-center justify-between">
                <span class="text-xs rounded-full bg-white/10 border border-white/10 px-3 py-1 text-white/80">
                    <?php echo e($tool->tag ?? 'IA'); ?>

                </span>
                <span class="text-cyan-300 opacity-80 group-hover:opacity-100 transition">↗</span>
            </div>

            <h3 class="mt-4 text-xl font-bold"><?php echo e($tool->title); ?></h3>
            <p class="mt-2 text-white/70"><?php echo e($tool->subtitle); ?></p>

            <?php if(!empty($tool->price)): ?>
                <div class="mt-3 text-white/80 font-semibold"><?php echo e($tool->price); ?></div>
            <?php endif; ?>

            <div class="mt-5 flex gap-3">
                <?php
                    $phone = preg_replace('/\D+/', '', config('services.whatsapp.number', env('WHATSAPP_NUMBER', '51978350894')));
                    $msg = "Hola, quiero contratar: {$tool->title}";
                    $waUrl = "https://wa.me/{$phone}?text=" . urlencode($msg);
                ?>

                
                <a class="btn-primary flex-1" href="<?php echo e($waUrl); ?>" target="_blank" rel="noopener">
                    <span class="inline-flex items-center justify-center gap-2">
                        <img
                            src="<?php echo e(asset('images/pngegg.png')); ?>"
                            alt="WhatsApp"
                            class="h-5 w-5"
                        >
                        Contratar
                    </span>
                </a>

                
                <a class="btn-tech flex-1" href="<?php echo e(route('precio')); ?>#tool-<?php echo e($tool->id); ?>">
                    Ver planes
                </a>
            </div>
        </div>
    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
        <div class="glass rounded-3xl p-8 text-white/70">
            Aún no hay herramientas creadas. (Admin → Dashboard)
        </div>
    <?php endif; ?>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.marketing', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Pagina-ia\resources\views/pages/herramientas.blade.php ENDPATH**/ ?>