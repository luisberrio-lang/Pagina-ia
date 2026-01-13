
<?php $__env->startSection('title', 'Soporte · GVelarde'); ?>

<?php $__env->startSection('content'); ?>
<div class="grid gap-8 lg:grid-cols-2 lg:items-start">
    <div>
        <h2 class="text-3xl font-extrabold">Soporte</h2>
        <p class="text-white/70 mt-2">Envíanos tu consulta. Se guarda como ticket en MySQL.</p>

        <div class="mt-6 glass rounded-3xl p-6 card-hover">
            <p class="font-semibold">Recomendación</p>
            <p class="text-white/70 mt-2">Describe tu problema y menciona la herramienta IA.</p>
        </div>
    </div>

    <div class="glass rounded-3xl p-6 md:p-8 card-hover">
        <?php if(session('ok')): ?>
            <div class="mb-4 rounded-2xl border border-emerald-400/20 bg-emerald-500/10 p-4 text-emerald-200">
                <?php echo e(session('ok')); ?>

            </div>
        <?php endif; ?>

        <form method="POST" action="<?php echo e(route('soporte.store')); ?>" class="space-y-4">
            <?php echo csrf_field(); ?>

            <div>
                <label class="text-sm text-white/70">Nombre</label>
                <input name="name" value="<?php echo e(old('name', auth()->user()->name ?? '')); ?>"
                       class="mt-1 w-full rounded-2xl bg-white/5 border border-white/10 px-4 py-3 outline-none focus:border-cyan-300/50"
                       required />
                <?php $__errorArgs = ['name'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> <p class="text-sm text-red-300 mt-1"><?php echo e($message); ?></p> <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
            </div>

            <div>
                <label class="text-sm text-white/70">Correo</label>
                <input name="email" type="email" value="<?php echo e(old('email', auth()->user()->email ?? '')); ?>"
                       class="mt-1 w-full rounded-2xl bg-white/5 border border-white/10 px-4 py-3 outline-none focus:border-cyan-300/50"
                       required />
                <?php $__errorArgs = ['email'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> <p class="text-sm text-red-300 mt-1"><?php echo e($message); ?></p> <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
            </div>

            <div>
                <label class="text-sm text-white/70">Asunto</label>
                <input name="subject" value="<?php echo e(old('subject')); ?>"
                       class="mt-1 w-full rounded-2xl bg-white/5 border border-white/10 px-4 py-3 outline-none focus:border-cyan-300/50"
                       required />
                <?php $__errorArgs = ['subject'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> <p class="text-sm text-red-300 mt-1"><?php echo e($message); ?></p> <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
            </div>

            <div>
                <label class="text-sm text-white/70">Mensaje</label>
                <textarea name="message" rows="5"
                          class="mt-1 w-full rounded-2xl bg-white/5 border border-white/10 px-4 py-3 outline-none focus:border-cyan-300/50"
                          required><?php echo e(old('message')); ?></textarea>
                <?php $__errorArgs = ['message'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> <p class="text-sm text-red-300 mt-1"><?php echo e($message); ?></p> <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
            </div>

            <button class="btn-primary w-full" type="submit">Enviar ticket</button>
        </form>
    </div>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.marketing', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Pagina-ia\resources\views\pages\soporte.blade.php ENDPATH**/ ?>