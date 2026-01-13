<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title><?php echo $__env->yieldContent('title', 'GVelarde'); ?></title>

  <?php echo app('Illuminate\Foundation\Vite')(['resources/css/app.css', 'resources/js/app.js']); ?>

  
  <link rel="icon" href="<?php echo e(asset('favicon.ico')); ?>?v=3">
  <link rel="icon" type="image/png" href="<?php echo e(asset('images/logopng.png')); ?>?v=3">
</head>

<body class="min-h-screen bg-slate-950 text-slate-100">

<!-- Fondo tech + robot -->
<div class="pointer-events-none fixed inset-0 -z-10 overflow-hidden">
  <div class="absolute -top-40 -left-40 h-96 w-96 rounded-full bg-fuchsia-600/20 blur-3xl"></div>
  <div class="absolute top-40 -right-40 h-[28rem] w-[28rem] rounded-full bg-cyan-400/15 blur-3xl"></div>
  <div class="absolute inset-0 bg-[radial-gradient(ellipse_at_top,rgba(99,102,241,0.18),transparent_60%)]"></div>
  <div class="absolute inset-0 opacity-30 [background-image:linear-gradient(to_right,rgba(255,255,255,.06)_1px,transparent_1px),linear-gradient(to_bottom,rgba(255,255,255,.06)_1px,transparent_1px)] [background-size:44px_44px]"></div>

  <img src="<?php echo e(asset('images/robot-3d.png')); ?>" alt="Robot 3D" class="hero-robot"/>
</div>

<?php
  // ✅ LINKS REALES
  $phoneHeader = preg_replace('/\D+/', '', env('WHATSAPP_NUMBER', '51951386898')); // +51 951 386 898
  $waHeaderUrl = "https://wa.me/{$phoneHeader}?text=" . urlencode("Hola, quiero información 👋");

  $fbUrl = "https://web.facebook.com/reel/4152099245054712";
  $ytUrl = "https://www.youtube.com/@Historiasenc%C3%B3digo";
?>

<header class="sticky top-0 z-40 border-b border-white/10 bg-slate-950/60 backdrop-blur-xl">
  <nav class="w-full flex items-center justify-between px-6 py-4">

    <!-- IZQUIERDA: LOGO -->
    <a href="<?php echo e(route('inicio')); ?>" class="flex items-center gap-3 shrink-0">
      <img
        src="<?php echo e(asset('images/logopagina.jpeg')); ?>"
        alt="G Velarde"
        class="h-10 w-10 rounded-xl object-cover border border-white/10 bg-white/5"
      >
      <span class="font-bold tracking-wide">
        G<span class="text-cyan-300">Velarde</span>
      </span>
    </a>

    <!-- CENTRO: MENÚ -->
    <div class="hidden md:flex flex-1 items-center justify-center gap-6">
      <a class="hover:text-cyan-300 transition" href="<?php echo e(route('inicio')); ?>">Inicio</a>
      <a class="hover:text-cyan-300 transition" href="<?php echo e(route('herramientas')); ?>">Herramientas IA</a>
      <a class="hover:text-cyan-300 transition" href="<?php echo e(route('precio')); ?>">Precio</a>
      <a class="hover:text-cyan-300 transition" href="<?php echo e(route('soporte')); ?>">Soporte</a>
      <a class="hover:text-cyan-300 transition" href="<?php echo e(route('faq')); ?>">FAQ</a>
    </div>

    <!-- DERECHA: ICONOS + BOTONES -->
    <div class="flex items-center gap-3 shrink-0">

      
      <div class="hidden sm:flex items-center gap-2 mr-1">

        <!-- WhatsApp (✅ a tu número) -->
        <a href="<?php echo e($waHeaderUrl); ?>" target="_blank" rel="noopener" aria-label="WhatsApp"
           class="h-10 w-10 rounded-xl bg-white/5 border border-white/10 flex items-center justify-center
                  hover:bg-white/10 hover:border-emerald-400/40 transition">
          <img src="<?php echo e(asset('images/pngegg.png')); ?>" alt="WhatsApp" class="h-5 w-5">
        </a>

        <!-- Facebook (✅ tu reel) -->
        <a href="<?php echo e($fbUrl); ?>" target="_blank" rel="noopener" aria-label="Facebook"
           class="h-10 w-10 rounded-xl bg-white/5 border border-white/10 flex items-center justify-center
                  hover:bg-white/10 hover:border-sky-400/40 transition">
          <svg class="h-5 w-5 text-sky-400" viewBox="0 0 24 24" fill="currentColor" aria-hidden="true">
            <path d="M22 12a10 10 0 1 0-11.5 9.9v-7H8v-2.9h2.5V9.8c0-2.5 1.5-3.9 3.8-3.9 1.1 0 2.2.2 2.2.2v2.4h-1.2c-1.2 0-1.6.8-1.6 1.5v1.8H17l-.5 2.9h-2.4v7A10 10 0 0 0 22 12z"/>
          </svg>
        </a>

        <!-- YouTube (✅ tu canal) -->
        <a href="<?php echo e($ytUrl); ?>" target="_blank" rel="noopener" aria-label="YouTube"
           class="h-10 w-10 rounded-xl bg-white/5 border border-white/10 flex items-center justify-center
                  hover:bg-white/10 hover:border-red-400/40 transition">
          <svg class="h-5 w-5 text-red-400" viewBox="0 0 24 24" fill="currentColor" aria-hidden="true">
            <path d="M21.6 7.2a3 3 0 0 0-2.1-2.1C17.9 4.7 12 4.7 12 4.7s-5.9 0-7.5.4A3 3 0 0 0 2.4 7.2 31.4 31.4 0 0 0 2 12a31.4 31.4 0 0 0 .4 4.8 3 3 0 0 0 2.1 2.1c1.6.4 7.5.4 7.5.4s5.9 0 7.5-.4a3 3 0 0 0 2.1-2.1A31.4 31.4 0 0 0 22 12a31.4 31.4 0 0 0-.4-4.8zM10 15.5v-7l6 3.5-6 3.5z"/>
          </svg>
        </a>

      </div>

      
      <?php if(auth()->guard()->guest()): ?>
        <a class="btn-tech" href="<?php echo e(route('login')); ?>">Iniciar sesión</a>
        <a class="btn-primary hidden sm:inline-flex" href="<?php echo e(route('register')); ?>">Crear cuenta</a>
      <?php endif; ?>

      
      <?php if(auth()->guard()->check()): ?>
        <?php if(auth()->user()->isAdmin()): ?>
          <a class="btn-tech" href="<?php echo e(route('admin.dashboard')); ?>">Dashboard</a>
          <a class="btn-tech" href="<?php echo e(route('admin.tickets')); ?>">Tickets</a>
        <?php endif; ?>

        <form method="POST" action="<?php echo e(route('logout')); ?>">
          <?php echo csrf_field(); ?>
          <button type="submit" class="btn-tech">Cerrar sesión</button>
        </form>
      <?php endif; ?>

    </div>
  </nav>
</header>

<main class="mx-auto max-w-6xl px-4 py-10">
  <div class="content-surface p-6 md:p-10">
    <?php echo $__env->yieldContent('content'); ?>
  </div>
</main>

<footer class="border-t border-white/10">
  <div class="mx-auto max-w-6xl px-4 py-10 text-sm flex flex-col md:flex-row gap-3 md:items-center md:justify-between">
    <p class="text-white/70">
      © <?php echo e(date('Y')); ?> <span class="font-semibold text-white/85">G Velarde</span>
    </p>

    <p class="text-white/60 md:text-right">
      <span class="font-semibold text-white/80">La central de las mejores IA</span>
      <span class="text-white/50">en un solo lugar.</span>
    </p>
  </div>
</footer>

</body>
</html>
<?php /**PATH C:\Pagina-ia\resources\views/layouts/marketing.blade.php ENDPATH**/ ?>