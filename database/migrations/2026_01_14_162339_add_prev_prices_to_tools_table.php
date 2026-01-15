<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::table('tools', function (Blueprint $table) {

            if (!Schema::hasColumn('tools', 'prev_price_monthly')) {
                $table->decimal('prev_price_monthly', 10, 2)->nullable()->after('price_monthly');
            }
            if (!Schema::hasColumn('tools', 'prev_price_bimestral')) {
                $table->decimal('prev_price_bimestral', 10, 2)->nullable()->after('price_bimestral');
            }
            if (!Schema::hasColumn('tools', 'prev_price_trimestral')) {
                $table->decimal('prev_price_trimestral', 10, 2)->nullable()->after('price_trimestral');
            }
            if (!Schema::hasColumn('tools', 'prev_price_semestral')) {
                $table->decimal('prev_price_semestral', 10, 2)->nullable()->after('price_semestral');
            }
            if (!Schema::hasColumn('tools', 'prev_price_anual')) {
                $table->decimal('prev_price_anual', 10, 2)->nullable()->after('price_anual');
            }
        });
    }

    public function down(): void
    {
        Schema::table('tools', function (Blueprint $table) {
            $cols = [
                'prev_price_monthly',
                'prev_price_bimestral',
                'prev_price_trimestral',
                'prev_price_semestral',
                'prev_price_anual',
            ];

            foreach ($cols as $c) {
                if (Schema::hasColumn('tools', $c)) {
                    $table->dropColumn($c);
                }
            }
        });
    }
};
