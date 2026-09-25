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
        Schema::create('transfer_network_profiles', function (Blueprint $table) {
            $table->id();
            $table->string('current_title');
            $table->string('current_institution');
            $table->string('target_locations');
            $table->unsignedSmallInteger('experience_years')->default(0);
            $table->text('summary');
            $table->string('contact_email');
            $table->boolean('is_identity_revealed')->default(false);
            $table->boolean('consent_accepted')->default(false);
            $table->string('status')->default('beklemede');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('transfer_network_profiles');
    }
};
