

<?php $__env->startSection('header'); ?>
<div class="font-semibold text-xl text-gray-800 leading-tight">
    Panel Cliente
</div>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('content'); ?>
<div class="py-8">
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">
            <p class="text-gray-700">Bienvenido, <?php echo e(auth()->user()->name); ?> ✅</p>
            <div class="mt-4 flex gap-4 flex-wrap">
                <a class="underline text-indigo-600" href="<?php echo e(route('herramientas')); ?>">Ver herramientas</a>
                <a class="underline text-indigo-600" href="<?php echo e(route('soporte')); ?>">Soporte</a>
            </div>
        </div>
    </div>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Pagina-ia\resources\views\cliente\dashboard.blade.php ENDPATH**/ ?>