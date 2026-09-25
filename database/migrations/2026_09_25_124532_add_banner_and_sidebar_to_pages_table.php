<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('pages', function (Blueprint $table) {
            $table->string('banner_title')->nullable();
            $table->string('banner_subtitle')->nullable();
            $table->text('banner_description')->nullable();
            $table->longText('sidebar_content')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('pages', function (Blueprint $table) {
            $table->dropColumn(['banner_title', 'banner_subtitle', 'banner_description', 'sidebar_content']);
        });
    }
};
