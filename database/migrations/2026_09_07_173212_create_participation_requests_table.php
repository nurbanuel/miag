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
        Schema::create('participation_requests', function (Blueprint $table) {
            $table->id();
            $table->enum('type', ['rapor_analiz', 'veri', 'etkinlik', 'yazi_iletisim']);
            $table->string('full_name');
            $table->string('email');
            $table->string('institution')->nullable();
            $table->text('message');
            $table->string('status')->default('beklemede');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('participation_requests');
    }
};
