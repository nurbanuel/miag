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
        Schema::create('job_internship_applications', function (Blueprint $table) {
            $table->id();
            $table->enum('applicant_type', ['yeni_mezun', 'deneyimli', 'stajyer']);
            $table->string('full_name');
            $table->string('email');
            $table->string('field_of_interest');
            $table->string('cv_path')->nullable();
            $table->text('message')->nullable();
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
        Schema::dropIfExists('job_internship_applications');
    }
};
