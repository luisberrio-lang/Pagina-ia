<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::table('tools', function (Blueprint $table) {
            $table->decimal('price_bimestral', 10, 2)->nullable()->after('price_monthly');
            $table->decimal('price_trimestral', 10, 2)->nullable()->after('price_bimestral');
        });
    }

    public function down(): void
    {
        Schema::table('tools', function (Blueprint $table) {
            $table->dropColumn(['price_bimestral', 'price_trimestral']);
        });
    }
};
