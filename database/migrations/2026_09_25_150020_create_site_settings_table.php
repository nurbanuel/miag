<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('site_settings', function (Blueprint $table) {
            $table->id();
            $table->json('header_menu')->nullable();
            $table->text('footer_about_text')->nullable();
            $table->json('footer_quick_links')->nullable();
            $table->json('footer_legal_links')->nullable();
            $table->string('footer_copyright_text')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('site_settings');
    }
};
