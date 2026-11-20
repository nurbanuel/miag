<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('site_settings', function (Blueprint $table) {
            $table->string('corporate_page_title')->nullable()->default('MİARGEM Kurumsal');
            $table->string('corporate_page_subtitle')->nullable()->default('Mahallî İdareler Araştırma ve Geliştirme Merkezi');
        });
    }

    public function down(): void
    {
        Schema::table('site_settings', function (Blueprint $table) {
            $table->dropColumn(['corporate_page_title', 'corporate_page_subtitle']);
        });
    }
};
