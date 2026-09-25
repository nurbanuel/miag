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
        Schema::create('expert_pool_profiles', function (Blueprint $table) {
            $table->id();
            $table->string('full_name');
            $table->string('email');
            $table->string('expertise_areas');
            $table->enum('visibility', ['miargem_only', 'municipality_projects', 'all_requests'])->default('miargem_only');
            $table->string('cv_path')->nullable();
            $table->text('summary');
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
        Schema::dropIfExists('expert_pool_profiles');
    }
};
