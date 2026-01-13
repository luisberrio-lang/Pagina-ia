<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::table('tools', function (Blueprint $table) {
            $table->string('short_desc', 180)->nullable()->after('subtitle');
            $table->string('badge_text', 50)->nullable()->after('short_desc');

            $table->json('highlights')->nullable()->after('badge_text'); // chips
            $table->json('includes')->nullable()->after('highlights');   // label + text
            $table->json('extras')->nullable()->after('includes');       // bullets

            $table->text('audience')->nullable()->after('extras');       // para quién es

            $table->decimal('price_monthly', 10, 2)->nullable()->after('audience');
            $table->decimal('price_semestral', 10, 2)->nullable()->after('price_monthly');
            $table->decimal('price_anual', 10, 2)->nullable()->after('price_semestral');

            $table->decimal('savings_semestral', 10, 2)->nullable()->after('price_anual');
            $table->decimal('savings_anual', 10, 2)->nullable()->after('savings_semestral');
        });
    }

    public function down(): void
    {
        Schema::table('tools', function (Blueprint $table) {
            $table->dropColumn([
                'short_desc','badge_text','highlights','includes','extras','audience',
                'price_monthly','price_semestral','price_anual','savings_semestral','savings_anual'
            ]);
        });
    }
};
