<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::table('tools', function (Blueprint $table) {

            $cols = [
                'old_price_monthly'    => 'price_monthly',
                'old_price_bimestral'  => 'price_bimestral',
                'old_price_trimestral' => 'price_trimestral',
                'old_price_semestral'  => 'price_semestral',
                'old_price_anual'      => 'price_anual',
            ];

            foreach ($cols as $old => $after) {
                if (!Schema::hasColumn('tools', $old)) {
                    // si existe la columna actual, la ponemos al costado
                    if (Schema::hasColumn('tools', $after)) {
                        $table->decimal($old, 10, 2)->nullable()->after($after);
                    } else {
                        $table->decimal($old, 10, 2)->nullable();
                    }
                }
            }
        });
    }

    public function down(): void
    {
        Schema::table('tools', function (Blueprint $table) {
            foreach ([
                'old_price_monthly',
                'old_price_bimestral',
                'old_price_trimestral',
                'old_price_semestral',
                'old_price_anual',
            ] as $col) {
                if (Schema::hasColumn('tools', $col)) {
                    $table->dropColumn($col);
                }
            }
        });
    }
};
