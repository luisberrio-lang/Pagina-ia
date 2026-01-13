
<?php $__env->startSection('title', 'Admin · Tickets'); ?>

<?php $__env->startSection('content'); ?>
<div class="flex items-center justify-between flex-wrap gap-3">
    <h2 class="text-3xl font-extrabold">Tickets</h2>

    <div class="flex gap-2">
        <a class="btn-tech" href="<?php echo e(route('admin.dashboard')); ?>">Dashboard</a>
        <a class="btn-tech" href="<?php echo e(route('admin.tickets')); ?>">Tickets</a>
    </div>
</div>

<div class="mt-6 glass rounded-3xl p-6">
    <h3 class="text-xl font-bold">Consultas de clientes</h3>
    <p class="text-white/70 mt-2">Vista de tickets funcionando ✅</p>

    <p class="text-white/50 mt-4 text-sm">
        Luego lo conectamos a la tabla support_tickets para listarlos aquí con nombre, email, asunto, mensaje, fecha.
    </p>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.marketing', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Pagina-ia\resources\views\admin\tickets.blade.php ENDPATH**/ ?>