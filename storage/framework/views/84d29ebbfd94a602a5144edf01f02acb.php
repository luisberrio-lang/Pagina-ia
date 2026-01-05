
<?php $__env->startSection('title', 'Admin · Dashboard'); ?>

<?php $__env->startSection('content'); ?>
<div class="flex items-center justify-between flex-wrap gap-3">
    <h2 class="text-3xl font-extrabold">Admin · Dashboard</h2>

    <div class="flex gap-2">
        <a class="btn-tech" href="<?php echo e(route('admin.dashboard')); ?>">Dashboard</a>
        <a class="btn-tech" href="<?php echo e(route('admin.tickets')); ?>">Tickets</a>
    </div>
</div>

<?php if(session('status')): ?>
    <div class="mt-4 glass rounded-2xl p-4 text-white/90">
        <?php echo e(session('status')); ?>

    </div>
<?php endif; ?>

<?php if($errors->any()): ?>
    <div class="mt-4 glass rounded-2xl p-4 text-white/90">
        <div class="font-bold mb-2">Corrige esto:</div>
        <ul class="list-disc ml-5 text-white/80">
            <?php $__currentLoopData = $errors->all(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $e): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?> <li><?php echo e($e); ?></li> <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        </ul>
    </div>
<?php endif; ?>

<div class="mt-6 grid gap-6 lg:grid-cols-2">
    <div class="glass rounded-3xl p-6">
        <h3 class="text-xl font-bold">Crear herramienta</h3>
        <p class="text-white/70 mt-1">Esto aparecerá automáticamente en “Herramientas IA”.</p>

        <form class="mt-5 space-y-4" method="POST" action="<?php echo e(route('admin.tools.store')); ?>">
            <?php echo csrf_field(); ?>

            <div>
                <label class="text-sm text-white/80">Tag</label>
                <input name="tag" class="mt-1 w-full rounded-xl bg-white/5 border border-white/10 px-4 py-3"
                       placeholder="Chatbot / Leads / Contenido" value="<?php echo e(old('tag')); ?>">
            </div>

            <div>
                <label class="text-sm text-white/80">Título</label>
                <input name="title" required class="mt-1 w-full rounded-xl bg-white/5 border border-white/10 px-4 py-3"
                       placeholder="IA Atención" value="<?php echo e(old('title')); ?>">
            </div>

            <div>
                <label class="text-sm text-white/80">Subtítulo</label>
                <input name="subtitle" required class="mt-1 w-full rounded-xl bg-white/5 border border-white/10 px-4 py-3"
                       placeholder="Responde clientes 24/7 con tono profesional." value="<?php echo e(old('subtitle')); ?>">
            </div>

            <div>
                <label class="text-sm text-white/80">Precio</label>
                <input name="price" class="mt-1 w-full rounded-xl bg-white/5 border border-white/10 px-4 py-3"
                       placeholder="S/50 x mes" value="<?php echo e(old('price')); ?>">
            </div>

            <div>
                <label class="text-sm text-white/80">Detalles del plan</label>
                <textarea name="details" rows="4"
                          class="mt-1 w-full rounded-xl bg-white/5 border border-white/10 px-4 py-3"
                          placeholder="Ej: 1 mes gratis, soporte 24/7, implementación incluida..."><?php echo e(old('details')); ?></textarea>
            </div>

            <div class="flex items-center gap-3">
                <div class="flex-1">
                    <label class="text-sm text-white/80">Orden</label>
                    <input name="sort_order" type="number" min="0" value="<?php echo e(old('sort_order', 0)); ?>"
                           class="mt-1 w-full rounded-xl bg-white/5 border border-white/10 px-4 py-3">
                </div>

                <label class="flex items-center gap-2 mt-6 text-white/80">
                    <input type="checkbox" name="is_active" <?php echo e(old('is_active', true) ? 'checked' : ''); ?>>
                    Activa
                </label>
            </div>

            <button class="btn-primary w-full" type="submit">Guardar</button>
        </form>
    </div>

    <div class="glass rounded-3xl p-6">
        <h3 class="text-xl font-bold">Herramientas creadas</h3>

        <div class="mt-4 space-y-3">
            <?php $__empty_1 = true; $__currentLoopData = $tools; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $tool): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                <div class="rounded-2xl border border-white/10 bg-white/5 p-4 flex items-start justify-between gap-4">
                    <div class="min-w-0">
                        <div class="text-xs text-white/70">
                            <?php echo e($tool->tag ?? 'IA'); ?> · Orden: <?php echo e($tool->sort_order); ?> · <?php echo e($tool->is_active ? 'Activa' : 'Inactiva'); ?>

                        </div>
                        <div class="font-bold"><?php echo e($tool->title); ?></div>
                        <div class="text-white/70 text-sm"><?php echo e($tool->subtitle); ?></div>
                        <?php if($tool->price): ?>
                            <div class="text-white/80 text-sm mt-2">💳 <b><?php echo e($tool->price); ?></b></div>
                        <?php endif; ?>
                        <?php if($tool->details): ?>
                            <div class="text-white/60 text-sm mt-1 truncate"><?php echo e($tool->details); ?></div>
                        <?php endif; ?>
                    </div>

                    <form method="POST" action="<?php echo e(route('admin.tools.destroy', $tool)); ?>">
                        <?php echo csrf_field(); ?>
                        <?php echo method_field('DELETE'); ?>
                        <button class="btn-tech" type="submit">Eliminar</button>
                    </form>
                </div>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                <div class="text-white/70">Aún no hay herramientas.</div>
            <?php endif; ?>
        </div>
    </div>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.marketing', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Pagina-ia\resources\views/admin/dashboard.blade.php ENDPATH**/ ?>