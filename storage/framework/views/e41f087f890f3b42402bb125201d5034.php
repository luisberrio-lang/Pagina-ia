
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
    <div class="flex items-center justify-between gap-3 flex-wrap">
        <div>
            <h3 class="text-xl font-bold">Consultas de clientes</h3>
            <p class="text-white/70 mt-2">Listado conectado a la tabla support_tickets.</p>
        </div>
        <span class="text-xs px-3 py-2 rounded-full bg-white/5 border border-white/10 text-white/70">
            <?php echo e($tickets->total()); ?> tickets
        </span>
    </div>

    <?php if($tickets->count() === 0): ?>
        <p class="text-white/60 mt-6">No hay tickets aún.</p>
    <?php else: ?>
        <div class="mt-6 grid gap-4">
            <?php $__currentLoopData = $tickets; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $ticket): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <div class="rounded-2xl border border-white/10 bg-white/5 p-5">
                    <div class="flex items-center justify-between gap-3 flex-wrap">
                        <div>
                            <p class="text-sm text-white/60">#<?php echo e($ticket->id); ?> · <?php echo e($ticket->created_at?->format('d/m/Y H:i')); ?></p>
                            <h4 class="text-lg font-semibold mt-1"><?php echo e($ticket->subject); ?></h4>
                        </div>
                        <span class="text-xs px-3 py-1.5 rounded-full border border-white/10 bg-white/10 text-white/70">
                            <?php echo e(ucfirst(str_replace('_', ' ', $ticket->status ?? 'abierto'))); ?>

                        </span>
                    </div>

                    <div class="mt-4 grid gap-2 text-sm text-white/75">
                        <p><span class="text-white/50">Nombre:</span> <?php echo e($ticket->name); ?></p>
                        <p><span class="text-white/50">Correo:</span> <?php echo e($ticket->email); ?></p>
                        <?php if($ticket->user): ?>
                            <p>
                                <span class="text-white/50">Usuario:</span>
                                <?php echo e($ticket->user->name); ?> (#<?php echo e($ticket->user->id); ?>)
                            </p>
                        <?php endif; ?>
                    </div>

                    <p class="text-white/70 mt-4 whitespace-pre-line"><?php echo e($ticket->message); ?></p>
                </div>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        </div>

        <div class="mt-6">
            <?php echo e($tickets->links()); ?>

        </div>
    <?php endif; ?>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.marketing', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\pagina-ia\resources\views/admin/tickets.blade.php ENDPATH**/ ?>