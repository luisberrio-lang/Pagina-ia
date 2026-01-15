<?php

use App\Models\User;
use Illuminate\Foundation\Inspiring;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Hash;

Artisan::command('inspire', function () {
    $this->comment(Inspiring::quote());
})->purpose('Display an inspiring quote');

Artisan::command('admin:create {email?} {--name=} {--password=}', function () {
    $email = $this->argument('email') ?? $this->ask('Correo del admin');
    $name = $this->option('name') ?? $this->ask('Nombre del admin', 'Admin');
    $password = $this->option('password') ?? $this->secret('Contraseña del admin');

    if (!$email || !$password) {
        $this->error('Correo y contraseña son obligatorios.');
        return 1;
    }

    User::updateOrCreate(
        ['email' => $email],
        [
            'name' => $name,
            'password' => Hash::make($password),
            'role' => 'admin',
        ]
    );

    $this->info("Admin listo: {$email}");

    return 0;
})->purpose('Crear o actualizar un usuario admin');
