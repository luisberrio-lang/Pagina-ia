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

            foreach ($cols as $oldCol => $priceCol) {
                if (!Schema::hasColumn('tools', $oldCol)) {
                    $table->decimal($oldCol, 10, 2)->nullable()->after($priceCol);
                }
            }
        });
    }

    public function down(): void
    {
        Schema::table('tools', function (Blueprint $table) {
            $drops = [
                'old_price_monthly',
                'old_price_bimestral',
                'old_price_trimestral',
                'old_price_semestral',
                'old_price_anual',
            ];

            foreach ($drops as $col) {
                if (Schema::hasColumn('tools', $col)) {
                    $table->dropColumn($col);
                }
            }
        });
    }
};
