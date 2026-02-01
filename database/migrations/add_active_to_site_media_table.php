<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('site_media', function (Blueprint $table) {
            if (!Schema::hasColumn('site_media', 'active')) {
                $table->boolean('active')->default(false)->after('size_bytes');
            }
        });
    }

    public function down(): void
    {
        Schema::table('site_media', function (Blueprint $table) {
            if (Schema::hasColumn('site_media', 'active')) {
                $table->dropColumn('active');
            }
        });
    }
};
