
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
    <div class="mt-4 glass rounded-2xl p-4 border border-red-500/30">
        <div class="font-bold text-red-200">Revisa el formulario:</div>
        <ul class="mt-2 text-white/80 text-sm list-disc list-inside">
            <?php $__currentLoopData = $errors->all(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $e): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <li><?php echo e($e); ?></li>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        </ul>
    </div>
<?php endif; ?>

<div class="mt-6 grid gap-6 lg:grid-cols-2">

    
    <div class="glass rounded-3xl p-6">
        <h3 class="text-xl font-bold">Crear pack</h3>
        <p class="text-white/70 mt-1">Esto se verá en Herramientas IA automáticamente.</p>

        <form class="mt-5 space-y-4" method="POST" action="<?php echo e(route('admin.tools.store')); ?>">
            <?php echo csrf_field(); ?>

            <div class="grid gap-3 sm:grid-cols-2">
                <div>
                    <label class="text-sm text-white/80">Tag</label>
                    <input name="tag" value="<?php echo e(old('tag')); ?>"
                           class="mt-1 w-full rounded-xl bg-white/5 border border-white/10 px-4 py-3"
                           placeholder="Chatbot / Contenido / Leads">
                </div>

                <div>
                    <label class="text-sm text-white/80">Badge (opcional)</label>
                    <input name="badge_text" value="<?php echo e(old('badge_text')); ?>"
                           class="mt-1 w-full rounded-xl bg-white/5 border border-white/10 px-4 py-3"
                           placeholder="MÁS VENDIDO">
                </div>
            </div>

            <div>
                <label class="text-sm text-white/80">Título</label>
                <input name="title" required value="<?php echo e(old('title')); ?>"
                       class="mt-1 w-full rounded-xl bg-white/5 border border-white/10 px-4 py-3"
                       placeholder="PACK MASTER IA PRO">
            </div>

            <div>
                <label class="text-sm text-white/80">Subtítulo</label>
                <input name="subtitle" required value="<?php echo e(old('subtitle')); ?>"
                       class="mt-1 w-full rounded-xl bg-white/5 border border-white/10 px-4 py-3"
                       placeholder="El equilibrio perfecto entre poder y precio">
            </div>

            <div>
                <label class="text-sm text-white/80">Descripción corta (opcional)</label>
                <input name="short_desc" value="<?php echo e(old('short_desc')); ?>"
                       class="mt-1 w-full rounded-xl bg-white/5 border border-white/10 px-4 py-3"
                       placeholder="Ideal para creadores de contenido, marketers y emprendedores.">
            </div>

            <div>
                <label class="text-sm text-white/80">Highlights (1 por línea)</label>
                <textarea name="highlights_text" rows="3"
                          class="mt-1 w-full rounded-xl bg-white/5 border border-white/10 px-4 py-3"
                          placeholder="Produce más contenido&#10;Monetiza con IA&#10;Todo listo para escalar"><?php echo e(old('highlights_text')); ?></textarea>
            </div>

            <div>
                <label class="text-sm text-white/80">¿Qué incluye? (1 por línea: Label|Texto)</label>
                <textarea name="includes_text" rows="6"
                          class="mt-1 w-full rounded-xl bg-white/5 border border-white/10 px-4 py-3"
                          placeholder="Base|Todo el Pack + 25+ herramientas&#10;Asistentes IA|ChatGPT · Gemini · Perplexity&#10;Diseño|Canva · Midjourney"><?php echo e(old('includes_text')); ?></textarea>
            </div>

            <div>
                <label class="text-sm text-white/80">Extras incluidos (1 por línea)</label>
                <textarea name="extras_text" rows="5"
                          class="mt-1 w-full rounded-xl bg-white/5 border border-white/10 px-4 py-3"
                          placeholder="Cursos completos&#10;Masterclass VIP&#10;Actualizaciones constantes"><?php echo e(old('extras_text')); ?></textarea>
            </div>

            <div>
                <label class="text-sm text-white/80">¿Para quién es este pack?</label>
                <textarea name="audience" rows="2"
                          class="mt-1 w-full rounded-xl bg-white/5 border border-white/10 px-4 py-3"
                          placeholder="Ideal para creadores, marketers y emprendedores."><?php echo e(old('audience')); ?></textarea>
            </div>

            <div class="grid gap-3 sm:grid-cols-3">
                <div>
                    <label class="text-sm text-white/80">Mensual ($)</label>
                    <input name="price_monthly" type="number" step="0.01" min="0" value="<?php echo e(old('price_monthly')); ?>"
                           class="mt-1 w-full rounded-xl bg-white/5 border border-white/10 px-4 py-3" placeholder="13">
                </div>
                <div>
                    <label class="text-sm text-white/80">Semestral ($)</label>
                    <input name="price_semestral" type="number" step="0.01" min="0" value="<?php echo e(old('price_semestral')); ?>"
                           class="mt-1 w-full rounded-xl bg-white/5 border border-white/10 px-4 py-3" placeholder="60">
                </div>
                <div>
                    <label class="text-sm text-white/80">Anual ($)</label>
                    <input name="price_anual" type="number" step="0.01" min="0" value="<?php echo e(old('price_anual')); ?>"
                           class="mt-1 w-full rounded-xl bg-white/5 border border-white/10 px-4 py-3" placeholder="100">
                </div>
            </div>

            <div class="grid gap-3 sm:grid-cols-3">
                <div>
                    <label class="text-sm text-white/80">Ahorro semestral ($)</label>
                    <input name="savings_semestral" type="number" step="0.01" min="0" value="<?php echo e(old('savings_semestral')); ?>"
                           class="mt-1 w-full rounded-xl bg-white/5 border border-white/10 px-4 py-3" placeholder="18">
                </div>
                <div>
                    <label class="text-sm text-white/80">Ahorro anual ($)</label>
                    <input name="savings_anual" type="number" step="0.01" min="0" value="<?php echo e(old('savings_anual')); ?>"
                           class="mt-1 w-full rounded-xl bg-white/5 border border-white/10 px-4 py-3" placeholder="56">
                </div>
                <div>
                    <label class="text-sm text-white/80">Orden</label>
                    <input name="sort_order" type="number" min="0" value="<?php echo e(old('sort_order', 0)); ?>"
                           class="mt-1 w-full rounded-xl bg-white/5 border border-white/10 px-4 py-3">
                </div>
            </div>

            <label class="flex items-center gap-2 text-white/80">
                <input type="checkbox" name="is_active" <?php echo e(old('is_active', true) ? 'checked' : ''); ?>>
                Activa
            </label>

            <button class="btn-primary w-full" type="submit">Guardar</button>
        </form>
    </div>

    
    <div class="glass rounded-3xl p-6">
        <h3 class="text-xl font-bold">Packs creados</h3>

        <div class="mt-4 space-y-3">
            <?php $__empty_1 = true; $__currentLoopData = $tools; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $tool): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                <?php
                    $highlightsText = is_array($tool->highlights ?? null) ? implode("\n", $tool->highlights) : '';
                    $extrasText     = is_array($tool->extras ?? null) ? implode("\n", $tool->extras) : '';
                    $includesText   = is_array($tool->includes ?? null)
                        ? collect($tool->includes)->map(fn($r) => trim(($r['label'] ?? '')).'|'.trim(($r['text'] ?? '')))->implode("\n")
                        : '';
                ?>

                <div class="rounded-2xl border border-white/10 bg-white/5 p-4">
                    <div class="flex items-start justify-between gap-4">
                        <div>
                            <div class="text-xs text-white/70">
                                <?php echo e($tool->tag ?? 'PACK'); ?> · Orden: <?php echo e($tool->sort_order); ?>

                                <?php if($tool->badge_text): ?> · <span class="text-cyan-200"><?php echo e($tool->badge_text); ?></span> <?php endif; ?>
                            </div>
                            <div class="font-bold"><?php echo e($tool->title); ?></div>
                            <div class="text-white/70 text-sm"><?php echo e($tool->subtitle); ?></div>
                            <div class="text-xs text-white/50 mt-1">
                                Mensual: $<?php echo e($tool->price_monthly ?? '-'); ?> · Sem: $<?php echo e($tool->price_semestral ?? '-'); ?> · Anual: $<?php echo e($tool->price_anual ?? '-'); ?>

                            </div>
                            <div class="text-xs text-white/50 mt-1">
                                <?php echo e($tool->is_active ? 'Activa' : 'Inactiva'); ?>

                            </div>
                        </div>

                        <form method="POST" action="<?php echo e(route('admin.tools.destroy', $tool)); ?>">
                            <?php echo csrf_field(); ?>
                            <?php echo method_field('DELETE'); ?>
                            <button class="btn-tech" type="submit">Eliminar</button>
                        </form>
                    </div>

                    
                    <details class="mt-4 rounded-2xl border border-white/10 bg-white/5 p-4">
                        <summary class="cursor-pointer text-white/80 font-semibold">✏️ Editar pack</summary>

                        <form class="mt-4 space-y-4" method="POST" action="<?php echo e(route('admin.tools.update', $tool)); ?>">
                            <?php echo csrf_field(); ?>
                            <?php echo method_field('PUT'); ?>

                            <div class="grid gap-3 sm:grid-cols-2">
                                <div>
                                    <label class="text-sm text-white/80">Tag</label>
                                    <input name="tag" value="<?php echo e(old('tag', $tool->tag)); ?>"
                                           class="mt-1 w-full rounded-xl bg-white/5 border border-white/10 px-4 py-3">
                                </div>

                                <div>
                                    <label class="text-sm text-white/80">Badge</label>
                                    <input name="badge_text" value="<?php echo e(old('badge_text', $tool->badge_text)); ?>"
                                           class="mt-1 w-full rounded-xl bg-white/5 border border-white/10 px-4 py-3">
                                </div>
                            </div>

                            <div>
                                <label class="text-sm text-white/80">Título</label>
                                <input name="title" required value="<?php echo e(old('title', $tool->title)); ?>"
                                       class="mt-1 w-full rounded-xl bg-white/5 border border-white/10 px-4 py-3">
                            </div>

                            <div>
                                <label class="text-sm text-white/80">Subtítulo</label>
                                <input name="subtitle" required value="<?php echo e(old('subtitle', $tool->subtitle)); ?>"
                                       class="mt-1 w-full rounded-xl bg-white/5 border border-white/10 px-4 py-3">
                            </div>

                            <div>
                                <label class="text-sm text-white/80">Descripción corta</label>
                                <input name="short_desc" value="<?php echo e(old('short_desc', $tool->short_desc)); ?>"
                                       class="mt-1 w-full rounded-xl bg-white/5 border border-white/10 px-4 py-3">
                            </div>

                            <div>
                                <label class="text-sm text-white/80">Highlights (1 por línea)</label>
                                <textarea name="highlights_text" rows="3"
                                          class="mt-1 w-full rounded-xl bg-white/5 border border-white/10 px-4 py-3"><?php echo e(old('highlights_text', $highlightsText)); ?></textarea>
                            </div>

                            <div>
                                <label class="text-sm text-white/80">Incluye (1 por línea: Label|Texto)</label>
                                <textarea name="includes_text" rows="6"
                                          class="mt-1 w-full rounded-xl bg-white/5 border border-white/10 px-4 py-3"><?php echo e(old('includes_text', $includesText)); ?></textarea>
                            </div>

                            <div>
                                <label class="text-sm text-white/80">Extras (1 por línea)</label>
                                <textarea name="extras_text" rows="5"
                                          class="mt-1 w-full rounded-xl bg-white/5 border border-white/10 px-4 py-3"><?php echo e(old('extras_text', $extrasText)); ?></textarea>
                            </div>

                            <div>
                                <label class="text-sm text-white/80">¿Para quién es?</label>
                                <textarea name="audience" rows="2"
                                          class="mt-1 w-full rounded-xl bg-white/5 border border-white/10 px-4 py-3"><?php echo e(old('audience', $tool->audience)); ?></textarea>
                            </div>

                            <div class="grid gap-3 sm:grid-cols-3">
                                <div>
                                    <label class="text-sm text-white/80">Mensual</label>
                                    <input name="price_monthly" type="number" step="0.01" min="0"
                                           value="<?php echo e(old('price_monthly', $tool->price_monthly)); ?>"
                                           class="mt-1 w-full rounded-xl bg-white/5 border border-white/10 px-4 py-3">
                                </div>
                                <div>
                                    <label class="text-sm text-white/80">Semestral</label>
                                    <input name="price_semestral" type="number" step="0.01" min="0"
                                           value="<?php echo e(old('price_semestral', $tool->price_semestral)); ?>"
                                           class="mt-1 w-full rounded-xl bg-white/5 border border-white/10 px-4 py-3">
                                </div>
                                <div>
                                    <label class="text-sm text-white/80">Anual</label>
                                    <input name="price_anual" type="number" step="0.01" min="0"
                                           value="<?php echo e(old('price_anual', $tool->price_anual)); ?>"
                                           class="mt-1 w-full rounded-xl bg-white/5 border border-white/10 px-4 py-3">
                                </div>
                            </div>

                            <div class="grid gap-3 sm:grid-cols-3">
                                <div>
                                    <label class="text-sm text-white/80">Ahorro semestral</label>
                                    <input name="savings_semestral" type="number" step="0.01" min="0"
                                           value="<?php echo e(old('savings_semestral', $tool->savings_semestral)); ?>"
                                           class="mt-1 w-full rounded-xl bg-white/5 border border-white/10 px-4 py-3">
                                </div>
                                <div>
                                    <label class="text-sm text-white/80">Ahorro anual</label>
                                    <input name="savings_anual" type="number" step="0.01" min="0"
                                           value="<?php echo e(old('savings_anual', $tool->savings_anual)); ?>"
                                           class="mt-1 w-full rounded-xl bg-white/5 border border-white/10 px-4 py-3">
                                </div>
                                <div>
                                    <label class="text-sm text-white/80">Orden</label>
                                    <input name="sort_order" type="number" min="0"
                                           value="<?php echo e(old('sort_order', $tool->sort_order)); ?>"
                                           class="mt-1 w-full rounded-xl bg-white/5 border border-white/10 px-4 py-3">
                                </div>
                            </div>

                            <label class="flex items-center gap-2 text-white/80">
                                <input type="checkbox" name="is_active" <?php echo e($tool->is_active ? 'checked' : ''); ?>>
                                Activa
                            </label>

                            <button class="btn-primary w-full" type="submit">Actualizar</button>
                        </form>
                    </details>
                </div>

            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                <div class="text-white/70">Aún no hay packs.</div>
            <?php endif; ?>
        </div>
    </div>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.marketing', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Pagina-ia\resources\views/admin/dashboard.blade.php ENDPATH**/ ?>