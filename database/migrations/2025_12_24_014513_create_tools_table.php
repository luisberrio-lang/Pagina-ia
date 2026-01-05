<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('tools', function (Blueprint $table) {
            $table->id();
            $table->string('tag', 50)->nullable();
            $table->string('title', 120);
            $table->string('subtitle', 255);
            $table->string('price', 60)->nullable();   // Ej: "S/ 49/mes"
            $table->text('details')->nullable();       // Ej: "Incluye: ..."

            $table->unsignedInteger('sort_order')->default(0);
            $table->boolean('is_active')->default(true);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('tools');
    }
};
