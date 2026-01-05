<?php $__env->startSection('title', 'Iniciar sesión · Pagina-IA'); ?>

<?php $__env->startSection('content'); ?>
<div class="mx-auto max-w-md glass rounded-3xl p-8">
    <h2 class="text-2xl font-extrabold">Iniciar sesión</h2>
    <p class="text-white/70 mt-2">Accede a tu cuenta para continuar.</p>

    <?php if(session('status')): ?>
        <div class="mt-4 rounded-2xl border border-white/10 bg-white/5 p-4 text-white/80">
            <?php echo e(session('status')); ?>

        </div>
    <?php endif; ?>

    <?php if($errors->any()): ?>
        <div class="mt-4 rounded-2xl border border-white/10 bg-white/5 p-4 text-white/80">
            <ul class="list-disc ml-5">
                <?php $__currentLoopData = $errors->all(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $e): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?> <li><?php echo e($e); ?></li> <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </ul>
        </div>
    <?php endif; ?>

    <form class="mt-6 space-y-4" method="POST" action="<?php echo e(route('login')); ?>">
        <?php echo csrf_field(); ?>

        <div>
            <label class="text-sm text-white/80">Email</label>
            <input name="email" type="email" required autofocus
                   value="<?php echo e(old('email')); ?>"
                   class="mt-1 w-full rounded-xl bg-white/5 border border-white/10 px-4 py-3">
        </div>

        <div>
            <label class="text-sm text-white/80">Password</label>
            <input name="password" type="password" required
                   class="mt-1 w-full rounded-xl bg-white/5 border border-white/10 px-4 py-3">
        </div>

        <label class="flex items-center gap-2 text-white/80">
            <input type="checkbox" name="remember">
            Recordarme
        </label>

        <button class="btn-primary w-full" type="submit">Entrar</button>

        <div class="text-center text-white/70 text-sm">
            ¿No tienes cuenta?
            <a class="text-cyan-300 hover:underline" href="<?php echo e(route('register')); ?>">Crear cuenta</a>
        </div>
    </form>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.marketing', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Pagina-ia\resources\views/auth/login.blade.php ENDPATH**/ ?>