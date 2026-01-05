<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::table('tools', function (Blueprint $table) {
            if (!Schema::hasColumn('tools', 'price')) {
                $table->string('price', 60)->nullable()->after('subtitle');
            }
            if (!Schema::hasColumn('tools', 'details')) {
                $table->text('details')->nullable()->after('price');
            }
        });
    }

    public function down(): void
    {
        Schema::table('tools', function (Blueprint $table) {
            if (Schema::hasColumn('tools', 'details')) $table->dropColumn('details');
            if (Schema::hasColumn('tools', 'price')) $table->dropColumn('price');
        });
    }
};
