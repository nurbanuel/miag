<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('reports', function (Blueprint $table) {
            // İçerik türü: Rapor | Analiz. Mevcut kayıtlar "Rapor" olur.
            $table->string('sub_category')->default('Rapor')->after('title');
        });
    }

    public function down(): void
    {
        Schema::table('reports', function (Blueprint $table) {
            $table->dropColumn('sub_category');
        });
    }
};
