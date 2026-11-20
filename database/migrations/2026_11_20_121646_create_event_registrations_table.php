<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('event_registrations', function (Blueprint $table) {
            $table->id();
            $table->foreignId('event_id')->constrained()->cascadeOnDelete();
            $table->foreignId('user_id')->nullable()->constrained()->nullOnDelete();
            $table->string('full_name');
            $table->string('institution');
            $table->string('department');
            $table->string('title');
            $table->string('email');
            $table->string('phone', 30);
            $table->boolean('is_mts_subscriber')->default(false);
            $table->timestamps();

            // Aynı etkinliğe aynı e-posta ile ikinci kayıt engellenir (doğrulamaya ek veritabanı güvencesi).
            $table->unique(['event_id', 'email']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('event_registrations');
    }
};
