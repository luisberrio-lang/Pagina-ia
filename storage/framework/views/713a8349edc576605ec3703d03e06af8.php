<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title><?php echo $__env->yieldContent('title', 'Pagina-IA'); ?></title>
    <?php echo app('Illuminate\Foundation\Vite')(['resources/css/app.css', 'resources/js/app.js']); ?>
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

<header class="sticky top-0 z-40 border-b border-white/10 bg-slate-950/60 backdrop-blur-xl">
    <nav class="mx-auto flex max-w-6xl items-center justify-between px-4 py-4">

        <!-- LOGO -->
        <a href="<?php echo e(route('inicio')); ?>" class="flex items-center gap-2">
            <span class="grid h-9 w-9 place-items-center rounded-xl bg-white/10 border border-white/10">
                <span class="text-cyan-300 font-bold">AI</span>
            </span>
            <span class="font-bold tracking-wide">
                Pagina<span class="text-cyan-300">-IA</span>
            </span>
        </a>

        <!-- MENÚ -->
        <div class="hidden items-center gap-6 md:flex">
            <a class="hover:text-cyan-300 transition" href="<?php echo e(route('inicio')); ?>">Inicio</a>
            <a class="hover:text-cyan-300 transition" href="<?php echo e(route('herramientas')); ?>">Herramientas IA</a>
            <a class="hover:text-cyan-300 transition" href="<?php echo e(route('precio')); ?>">Precio</a>
            <a class="hover:text-cyan-300 transition" href="<?php echo e(route('soporte')); ?>">Soporte</a>
            <a class="hover:text-cyan-300 transition" href="<?php echo e(route('faq')); ?>">FAQ</a>
        </div>

        <!-- BOTONES (RESULTADO FINAL) -->
        <div class="flex items-center gap-3">

            
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
    <div class="mx-auto max-w-6xl px-4 py-10 text-sm text-white/70 flex flex-col md:flex-row gap-3 md:items-center md:justify-between">
        <p>© <?php echo e(date('Y')); ?> Pagina-IA</p>
        <p class="text-white/50">Laravel + Tailwind</p>
    </div>
</footer>

</body>
</html>
<?php /**PATH C:\Pagina-ia\resources\views/layouts/marketing.blade.php ENDPATH**/ ?>