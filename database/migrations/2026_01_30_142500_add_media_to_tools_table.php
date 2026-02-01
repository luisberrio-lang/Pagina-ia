<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('tools', function (Blueprint $table) {
            $table->string('media_path')->nullable();
            $table->string('media_mime', 64)->nullable();
            $table->string('media_original_name')->nullable();
            $table->unsignedBigInteger('media_size_bytes')->nullable();
            $table->boolean('media_active')->default(false);
        });
    }

    public function down(): void
    {
        Schema::table('tools', function (Blueprint $table) {
            $table->dropColumn([
                'media_path',
                'media_mime',
                'media_original_name',
                'media_size_bytes',
                'media_active',
            ]);
        });
    }
};
