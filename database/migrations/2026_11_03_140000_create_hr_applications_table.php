<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('hr_applications', function (Blueprint $table) {
            $table->id();
            $table->enum('type', ['personel_talebi', 'nakil', 'is_staj'])->index();
            $table->string('professional_title')->nullable();
            $table->string('staff_title')->nullable();
            $table->string('actual_duty')->nullable();
            $table->string('unit')->nullable();
            $table->string('work_status')->nullable();
            $table->string('job_search_status')->nullable();
            $table->string('institution_type')->nullable();
            $table->boolean('contact_info_public')->default(false);
            $table->boolean('cv_public')->default(false);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('hr_applications');
    }
};
