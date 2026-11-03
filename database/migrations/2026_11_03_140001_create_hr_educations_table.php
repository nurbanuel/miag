<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('hr_educations', function (Blueprint $table) {
            $table->id();
            $table->foreignId('hr_application_id')->constrained()->cascadeOnDelete();
            $table->string('education_level');
            $table->string('student_status');
            $table->string('university')->nullable();
            $table->string('faculty')->nullable();
            $table->string('department')->nullable();
            $table->unsignedSmallInteger('graduation_year')->nullable();
            $table->string('current_class')->nullable();
            $table->date('expected_graduation_date')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('hr_educations');
    }
};
