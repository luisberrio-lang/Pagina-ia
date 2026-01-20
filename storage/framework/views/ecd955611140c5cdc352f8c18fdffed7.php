<?php $__env->startSection('title', 'Herramientas IA · GVelarde'); ?>

<?php $__env->startSection('content'); ?>
<?php
  $phone = preg_replace('/\D+/', '', env('WHATSAPP_NUMBER', '51951386898'));
?>

<div class="flex items-end justify-between gap-4 flex-wrap">
  <div>
    <h2 class="text-3xl font-extrabold">Herramientas IA</h2>
    <p class="text-white/70 mt-2">Elige un pack y revisa planes, detalles y beneficios.</p>
  </div>
  <a href="<?php echo e(route('soporte')); ?>" class="btn-tech">Soporte</a>
</div>

<?php if($tools->isEmpty()): ?>
  <div class="mt-8 neon-frame">
    <div class="neon-inner p-8 text-white/70">
      Aún no hay packs creados. (Admin → Dashboard)
    </div>
  </div>
<?php else: ?>
  <?php $activeTool = $activeTool ?? $tools->first(); ?>

  
  <div class="mt-8 grid gap-4 md:grid-cols-3">
    <?php $__currentLoopData = $tools; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $t): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
      <?php
        $from = $t->price_monthly ? 'S/. '.number_format($t->price_monthly, 0).' mensual' : 'Consultar';
        $isActive = $activeTool && $activeTool->id === $t->id;
      ?>

      <div class="neon-frame <?php echo e($isActive ? 'neon-selected' : ''); ?>">
        <div class="neon-inner relative p-4 sm:p-5 pb-12 min-h-[175px]">
          <div class="flex items-center justify-between gap-2">
            <div class="text-xs text-white/70 font-semibold uppercase tracking-wide">
              <?php echo e($t->tag ?? 'PACK'); ?>

            </div>

            <?php if($t->badge_text): ?>
              <span class="text-[10px] px-3 py-1 rounded-full font-extrabold shrink-0"
                    style="background:#D3FF00;border:1px solid #D3FF00;color:#000;
                           box-shadow:0 0 10px rgba(211,255,0,.75),0 0 22px rgba(211,255,0,.45);">
                <?php echo e($t->badge_text); ?>

              </span>
            <?php endif; ?>
          </div>

          <div class="mt-2 font-extrabold leading-tight text-white/95">
            <?php echo e($t->title); ?>

          </div>

          <div class="text-white/70 text-sm leading-snug mt-1">
            <?php echo e($t->subtitle); ?>

          </div>

          <div class="mt-4 text-xs text-white/50">DESDE</div>
          <div class="text-cyan-200 font-extrabold text-xl leading-tight">
            <?php echo e($from); ?>

          </div>

          <a href="<?php echo e(route('herramientas', ['tool' => $t->id])); ?>#planes"
             class="mt-3 inline-flex w-full items-center justify-center rounded-lg px-3 py-2 text-[12px] font-semibold
                    text-white transition
                    sm:absolute sm:bottom-3 sm:right-3 sm:w-auto"
             style="background:#1D00F5;border:1px solid #1D00F5;
                    box-shadow:0 0 10px rgba(29,0,245,.65),0 0 28px rgba(29,0,245,.45);"
             onmouseover="this.style.background='#3A1BFF';this.style.borderColor='#3A1BFF';this.style.boxShadow='0 0 12px rgba(29,0,245,.80),0 0 36px rgba(29,0,245,.55)';"
             onmouseout="this.style.background='#1D00F5';this.style.borderColor='#1D00F5';this.style.boxShadow='0 0 10px rgba(29,0,245,.65),0 0 28px rgba(29,0,245,.45)';">
            Ver detalles y planes
          </a>
        </div>
      </div>
    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
  </div>

  
  <div id="planes" class="mt-8 neon-frame">
    <div class="neon-inner p-6 md:p-10">
      <div class="grid gap-10 lg:grid-cols-2">

        
        <div>
          <?php if($activeTool->badge_text): ?>
            <span class="text-[12px] px-3 py-1 rounded-full font-extrabold shrink-0"
                  style="background:#D3FF00;border:1px solid #D3FF00;color:#000;
                         box-shadow:0 0 10px rgba(211,255,0,.75),0 0 22px rgba(211,255,0,.45);">
              <?php echo e($activeTool->badge_text); ?>

            </span>
          <?php endif; ?>

          <h3 class="mt-3 text-3xl font-extrabold"><?php echo e($activeTool->title); ?></h3>
          <p class="mt-2 text-white/70"><?php echo e($activeTool->short_desc ?? $activeTool->subtitle); ?></p>

          <?php if(!empty($activeTool->highlights)): ?>
            <div class="mt-4 flex flex-wrap gap-2">
              <?php $__currentLoopData = $activeTool->highlights; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $h): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <span class="inline-flex items-center gap-2 rounded-full bg-white/5 border border-white/12 px-3 py-1 text-sm text-white/85">
                  <span class="h-2 w-2 rounded-full bg-emerald-400"></span>
                  <span class="u-minw-0"><?php echo e($h); ?></span>
                </span>
              <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </div>
          <?php endif; ?>

          <div class="mt-8">
            <div class="text-xs tracking-widest text-white/50">¿QUÉ INCLUYE?</div>
            <div class="mt-4 space-y-2 text-white/85">
              <?php $__currentLoopData = ($activeTool->includes ?? []); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $row): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <div>
                  <span class="font-semibold"><?php echo e($row['label'] ?? ''); ?>:</span>
                  <?php echo e($row['text'] ?? ''); ?>

                </div>
              <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </div>
          </div>

          <?php if(!empty($activeTool->extras)): ?>
            <div class="mt-8">
              <div class="text-xs tracking-widest text-white/50">EXTRAS INCLUIDOS</div>
              <ul class="mt-3 space-y-2 text-white/80 list-disc list-inside">
                <?php $__currentLoopData = $activeTool->extras; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $e): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                  <li><?php echo e($e); ?></li>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
              </ul>
            </div>
          <?php endif; ?>
        </div>

        
        <div>
          <div class="text-xs tracking-widest text-white/50 mb-4">PLANES DEL PACK</div>

          <?php
            $plans = [
              ['key'=>'monthly',    'label'=>'Mensual',    'period'=>'mensual',    'price'=>$activeTool->price_monthly,    'old'=>$activeTool->old_price_monthly],
              ['key'=>'bimestral',  'label'=>'Bimestral',  'period'=>'bimestral',  'price'=>$activeTool->price_bimestral,  'old'=>$activeTool->old_price_bimestral],
              ['key'=>'trimestral', 'label'=>'Trimestral', 'period'=>'trimestral', 'price'=>$activeTool->price_trimestral, 'old'=>$activeTool->old_price_trimestral],
              ['key'=>'semestral',  'label'=>'Semestral',  'period'=>'semestral',  'price'=>$activeTool->price_semestral,  'old'=>$activeTool->old_price_semestral],
              ['key'=>'anual',      'label'=>'Anual',      'period'=>'anual',      'price'=>$activeTool->price_anual,      'old'=>$activeTool->old_price_anual],
            ];

            $calcOff = function($old, $new){
              $old = (float)$old; $new = (float)$new;
              if ($old > 0 && $new > 0 && $old > $new) {
                return (int) round((($old - $new) / $old) * 100);
              }
              return null;
            };
          ?>

          <div class="grid gap-4 sm:grid-cols-2 lg:grid-cols-3">
            <?php $__currentLoopData = $plans; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $p): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
              <?php
                $hasPrice = !is_null($p['price']) && (float)$p['price'] > 0;
                $price = $hasPrice ? number_format((float)$p['price'], 0) : null;

                $hasOld = !is_null($p['old']) && (float)$p['old'] > 0;
                $old = $hasOld ? number_format((float)$p['old'], 0) : null;

                $off = ($hasOld && $hasPrice) ? $calcOff($p['old'], $p['price']) : null;
              ?>

              <div class="neon-frame <?php echo e($p['key']==='monthly' ? 'neon-gold' : ''); ?> <?php echo e($p['key']==='anual' ? 'neon-purple' : ''); ?>">
                
                <div class="neon-inner p-4">
                  <div class="flex items-start justify-between gap-3">
                    <div class="text-sm font-extrabold text-white/95">
                      <?php echo e($p['label']); ?>

                    </div>
                  </div>

                  
                  <?php if($hasPrice && $hasOld && $off): ?>
                    <div class="mt-2 inline-flex items-center gap-2 flex-nowrap whitespace-nowrap">
                      <span class="text-xs text-white/55 line-through whitespace-nowrap shrink-0">
                        S/. <?php echo e($old); ?>

                      </span>

                      <span class="text-[11px] px-2.5 py-1 rounded-full whitespace-nowrap shrink-0 font-semibold tracking-wide text-black"
                            style="background:#D3FF00;border:1px solid #D3FF00;color:#000;
                                   box-shadow:0 0 10px rgba(211,255,0,.85),0 0 24px rgba(211,255,0,.55);">
                        <?php echo e($off); ?>% OFF
                      </span>
                    </div>
                  <?php endif; ?>

                  
                  <div class="mt-2">
                    <?php if($hasPrice): ?>
                      <div class="flex items-end gap-2 text-white leading-none">
                        <span class="text-2xl sm:text-3xl font-bold tracking-tight">S/.</span>
                        <span class="text-4xl font-extrabold"><?php echo e($price); ?></span>
                      </div>

                      
                      <div class="mt-2 text-sm text-white/60">
                        S/. <?php echo e($price); ?> <?php echo e($p['period']); ?>

                      </div>
                    <?php else: ?>
                      <div class="text-3xl font-extrabold text-cyan-200 leading-none">
                        Consultar
                      </div>
                      <div class="mt-2 text-sm text-white/55">
                        Consultar <?php echo e($p['period']); ?>

                      </div>
                    <?php endif; ?>
                  </div>
                </div>
              </div>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
          </div>

          <div class="mt-8">
            <div class="text-xs tracking-widest text-white/50">¿PARA QUIÉN ES ESTE PACK?</div>
            <p class="mt-3 text-white/70">
              <?php echo e($activeTool->audience ?? 'Ideal para creadores de contenido, marketers y emprendedores.'); ?>

            </p>
          </div>

          <?php
            $msg = "Hola, quiero este pack: {$activeTool->title}";
            $waUrl = "https://wa.me/{$phone}?text=" . urlencode($msg);
          ?>

          <div class="mt-8">
            <a href="<?php echo e($waUrl); ?>" target="_blank" rel="noopener"
               class="inline-flex w-full items-center justify-center gap-3 rounded-2xl px-6 py-4 font-extrabold
                      text-white transition"
               style="background:#25D350;box-shadow:0 0 12px rgba(37,211,80,.55),0 0 28px rgba(37,211,80,.30);"
               onmouseover="this.style.background='#35E062';"
               onmouseout="this.style.background='#25D350';">
              <img src="<?php echo e(asset('images/pngegg.png')); ?>" alt="WhatsApp" class="h-6 w-6">
              Contratar por WhatsApp
            </a>
          </div>

          <p class="mt-2 text-xs text-white/50">
            Te respondemos con los detalles del pack, ejemplos de uso y los pasos para activarlo en minutos.
          </p>
        </div>

      </div>
    </div>
  </div>
<?php endif; ?>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.marketing', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\pagina-ia\resources\views/pages/herramientas.blade.php ENDPATH**/ ?>