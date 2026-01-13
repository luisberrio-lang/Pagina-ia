
<?php $__env->startSection('title', 'Precios · Pagina-IA'); ?>

<?php $__env->startSection('content'); ?>
<?php
    // Si no hay herramientas, evitamos errores
    $activeTool = $activeTool ?? null;

    // WhatsApp
    $phone = preg_replace('/\D+/', '', config('services.whatsapp.number', env('WHATSAPP_NUMBER', '51978350894')));

    // Helpers para listas (sirve si guardas arrays o texto por líneas)
    $toList = function ($value) {
        if (is_array($value)) return array_values(array_filter($value));
        if (is_string($value) && trim($value) !== '') {
            return array_values(array_filter(array_map('trim', preg_split("/\r\n|\n|\r/", $value))));
        }
        return [];
    };
?>

<div class="flex items-end justify-between gap-4 flex-wrap">
    <div>
        <h2 class="text-3xl font-extrabold">Precios</h2>
        <p class="text-white/70 mt-2">Planes y detalles por herramienta.</p>
    </div>

    <a href="<?php echo e(route('herramientas')); ?>" class="btn-tech">Volver</a>
</div>


<?php if($tools->count()): ?>
    <div class="mt-6 flex gap-3 overflow-x-auto pb-2">
        <?php $__currentLoopData = $tools; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $t): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
            <?php
                $isActive = $activeTool && $activeTool->id === $t->id;
            ?>
            <a href="<?php echo e(route('precio', ['tool' => $t->id])); ?>"
               class="shrink-0 glass rounded-2xl px-4 py-3 border
                      <?php echo e($isActive ? 'border-cyan-300/60' : 'border-white/10'); ?>">
                <div class="text-xs text-white/60"><?php echo e($t->tag ?? 'IA'); ?></div>
                <div class="font-semibold"><?php echo e($t->title); ?></div>
                <div class="text-xs text-white/60 mt-1 line-clamp-1"><?php echo e($t->subtitle); ?></div>
            </a>
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
    </div>
<?php endif; ?>


<?php if($activeTool): ?>
    <?php
        // Campos nuevos (si aún no existen en tu tabla, simplemente saldrán null y no rompen nada)
        $badge = $activeTool->badge_text ?? null;
        $short = $activeTool->short_desc ?? null;

        $highlights = $toList($activeTool->highlights ?? null);
        $includes   = $toList($activeTool->includes ?? null);
        $extras     = $toList($activeTool->extras ?? null);

        // Precios (fallback al campo antiguo price)
        $monthly   = $activeTool->price_monthly ?? $activeTool->price ?? null;
        $semestral = $activeTool->price_semestral ?? null;
        $anual     = $activeTool->price_anual ?? null;

        $saveSem   = $activeTool->savings_semestral ?? null;
        $saveAnual = $activeTool->savings_anual ?? null;

        // Mensaje WhatsApp
        $msg = "Hola, quiero contratar: {$activeTool->title}";
        $waUrl = "https://wa.me/{$phone}?text=" . urlencode($msg);
    ?>

    <div id="tool-<?php echo e($activeTool->id); ?>" class="mt-8 glass rounded-3xl p-6 md:p-10 border border-white/10">
        <div class="flex items-start justify-between gap-6 flex-wrap">
            <div class="max-w-2xl">
                <div class="flex items-center gap-2">
                    <span class="text-xs rounded-full bg-white/10 border border-white/10 px-3 py-1 text-white/80">
                        <?php echo e($activeTool->tag ?? 'IA'); ?>

                    </span>

                    <?php if($badge): ?>
                        <span class="text-xs rounded-full bg-cyan-300/15 border border-cyan-300/30 px-3 py-1 text-cyan-200">
                            <?php echo e($badge); ?>

                        </span>
                    <?php endif; ?>
                </div>

                <h3 class="mt-4 text-3xl font-extrabold"><?php echo e($activeTool->title); ?></h3>
                <p class="mt-2 text-white/70"><?php echo e($activeTool->subtitle); ?></p>

                <?php if($short): ?>
                    <p class="mt-4 text-white/70"><?php echo e($short); ?></p>
                <?php endif; ?>

                
                <?php if(count($highlights)): ?>
                    <div class="mt-5 flex flex-wrap gap-2">
                        <?php $__currentLoopData = $highlights; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $h): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <span class="text-xs rounded-full bg-white/10 border border-white/10 px-3 py-1 text-white/80">
                                ✅ <?php echo e($h); ?>

                            </span>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </div>
                <?php endif; ?>

                
                <?php
                    $detailsLines = $toList($activeTool->details ?? null);
                ?>

                <?php if(count($includes) || count($detailsLines)): ?>
                    <div class="mt-6">
                        <div class="text-xs tracking-widest text-white/50">¿QUÉ INCLUYE?</div>
                        <ul class="mt-3 space-y-2 text-white/80">
                            <?php $__currentLoopData = count($includes) ? $includes : $detailsLines; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $it): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <li class="flex gap-2">
                                    <span class="text-cyan-300">•</span> <span><?php echo e($it); ?></span>
                                </li>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </ul>
                    </div>
                <?php endif; ?>

                <?php if(count($extras)): ?>
                    <div class="mt-6">
                        <div class="text-xs tracking-widest text-white/50">EXTRAS INCLUIDOS</div>
                        <ul class="mt-3 space-y-2 text-white/80">
                            <?php $__currentLoopData = $extras; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $ex): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <li class="flex gap-2">
                                    <span class="text-cyan-300">•</span> <span><?php echo e($ex); ?></span>
                                </li>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </ul>
                    </div>
                <?php endif; ?>
            </div>

            
            <div class="w-full max-w-md">
                <div class="text-xs tracking-widest text-white/50 mb-3">PRECIOS DEL PLAN</div>

                <div class="grid gap-3 sm:grid-cols-3">
                    
                    <div class="rounded-2xl border border-white/10 bg-white/5 p-4">
                        <div class="text-xs text-white/70">ANUAL</div>
                        <div class="text-2xl font-extrabold mt-2">
                            <?php echo e($anual ?? '—'); ?>

                        </div>
                        <?php if($saveAnual): ?>
                            <div class="text-xs text-emerald-300 mt-1">ahorras <?php echo e($saveAnual); ?></div>
                        <?php endif; ?>
                    </div>

                    
                    <div class="rounded-2xl border border-white/10 bg-white/5 p-4">
                        <div class="text-xs text-white/70">SEMESTRAL</div>
                        <div class="text-2xl font-extrabold mt-2">
                            <?php echo e($semestral ?? '—'); ?>

                        </div>
                        <?php if($saveSem): ?>
                            <div class="text-xs text-emerald-300 mt-1">ahorras <?php echo e($saveSem); ?></div>
                        <?php endif; ?>
                    </div>

                    
                    <div class="rounded-2xl border border-white/10 bg-white/5 p-4">
                        <div class="text-xs text-white/70">MENSUAL</div>
                        <div class="text-2xl font-extrabold mt-2">
                            <?php echo e($monthly ?? 'Consultar'); ?>

                        </div>
                    </div>
                </div>

                <a href="<?php echo e($waUrl); ?>" target="_blank" rel="noopener"
                   class="mt-6 inline-flex w-full items-center justify-center gap-2 rounded-2xl px-5 py-4 font-semibold
                          bg-emerald-500 hover:bg-emerald-600 transition text-white">
                    <img src="<?php echo e(asset('images/pngegg.png')); ?>" alt="WhatsApp" class="h-5 w-5">
                    QUIERO ESTE PLAN por WhatsApp
                </a>

                <p class="mt-3 text-xs text-white/60">
                    Te respondemos con los detalles del plan, ejemplos y pasos para activarlo.
                </p>
            </div>
        </div>
    </div>
<?php else: ?>
    <div class="mt-8 glass rounded-3xl p-8 text-white/70">
        Aún no hay planes/herramientas creadas.
    </div>
<?php endif; ?>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.marketing', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Pagina-ia\resources\views\pages\precio.blade.php ENDPATH**/ ?>