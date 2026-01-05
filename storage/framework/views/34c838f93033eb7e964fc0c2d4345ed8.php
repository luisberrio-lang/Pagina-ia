
<?php $__env->startSection('title', 'Inicio · Pagina-IA'); ?>

<?php $__env->startSection('content'); ?>
<section class="grid gap-8 md:grid-cols-2 md:items-center">
    <div class="space-y-5">
        <div class="inline-flex items-center gap-2 rounded-full border border-white/10 bg-white/5 px-4 py-2 text-sm text-white/80">
            <span class="h-2 w-2 rounded-full bg-cyan-300 animate-pulse"></span>
            Mostrador de herramientas IA
        </div>

        <h1 class="text-4xl md:text-5xl font-extrabold leading-tight">
            Una vitrina <span class="text-cyan-300">moderna</span> para tus IAs
        </h1>

        <p class="text-white/75 text-lg">
            Ordenada, clara y con estilo tecnológico. Ideal para mostrar tus servicios y captar clientes.
        </p>

        <div class="flex flex-wrap gap-3">
            <a href="<?php echo e(route('herramientas')); ?>" class="btn-primary">Ver herramientas</a>
            <a href="<?php echo e(route('precio')); ?>" class="btn-tech">Ver precios</a>
        </div>
    </div>

    <div class="glass rounded-3xl p-6 md:p-8 card-hover">
        <p class="font-semibold">Destacados</p>
        <div class="mt-5 grid gap-4">
            <?php $__currentLoopData = [
                ['name'=>'IA Atención', 'desc'=>'Respuestas rápidas y consistentes.'],
                ['name'=>'IA Marketing', 'desc'=>'Contenido y anuncios listos.'],
                ['name'=>'IA Ventas', 'desc'=>'Seguimiento y cierres.'],
            ]; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $tool): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <div class="glass rounded-2xl p-4 card-hover">
                    <p class="font-semibold"><?php echo e($tool['name']); ?></p>
                    <p class="text-white/70 text-sm"><?php echo e($tool['desc']); ?></p>
                </div>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        </div>
    </div>
</section>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.marketing', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Pagina-ia\resources\views/pages/inicio.blade.php ENDPATH**/ ?>