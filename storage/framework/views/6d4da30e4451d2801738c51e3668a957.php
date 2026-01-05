<?php $__env->startSection('title', 'Crear cuenta · Pagina-IA'); ?>

<?php $__env->startSection('content'); ?>
<div class="mx-auto max-w-md glass rounded-3xl p-8">
    <h2 class="text-2xl font-extrabold">Crear cuenta</h2>
    <p class="text-white/70 mt-2">Regístrate en Pagina-IA.</p>

    <?php if($errors->any()): ?>
        <div class="mt-4 rounded-2xl border border-white/10 bg-white/5 p-4 text-white/80">
            <ul class="list-disc ml-5">
                <?php $__currentLoopData = $errors->all(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $e): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?> <li><?php echo e($e); ?></li> <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </ul>
        </div>
    <?php endif; ?>

    <form class="mt-6 space-y-4" method="POST" action="<?php echo e(route('register')); ?>">
        <?php echo csrf_field(); ?>

        <div>
            <label class="text-sm text-white/80">Nombre</label>
            <input name="name" required value="<?php echo e(old('name')); ?>"
                   class="mt-1 w-full rounded-xl bg-white/5 border border-white/10 px-4 py-3">
        </div>

        <div>
            <label class="text-sm text-white/80">Email</label>
            <input name="email" type="email" required value="<?php echo e(old('email')); ?>"
                   class="mt-1 w-full rounded-xl bg-white/5 border border-white/10 px-4 py-3">
        </div>

        <div>
            <label class="text-sm text-white/80">Password</label>
            <input name="password" type="password" required
                   class="mt-1 w-full rounded-xl bg-white/5 border border-white/10 px-4 py-3">
        </div>

        <div>
            <label class="text-sm text-white/80">Confirmar Password</label>
            <input name="password_confirmation" type="password" required
                   class="mt-1 w-full rounded-xl bg-white/5 border border-white/10 px-4 py-3">
        </div>

        <button class="btn-primary w-full" type="submit">Registrar</button>

        <div class="text-center text-white/70 text-sm">
            ¿Ya tienes cuenta?
            <a class="text-cyan-300 hover:underline" href="<?php echo e(route('login')); ?>">Iniciar sesión</a>
        </div>
    </form>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.marketing', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Pagina-ia\resources\views/auth/register.blade.php ENDPATH**/ ?>