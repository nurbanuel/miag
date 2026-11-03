<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        // İş başvurularından (hr_applications) bağımsız kurum personel talepleri.
        Schema::create('hr_personnel_requests', function (Blueprint $table) {
            $table->id();

            // Kurum ve yetkili
            $table->string('institution_name');
            $table->string('institution_type');
            $table->string('unit')->nullable();
            $table->string('authorized_person_name');
            $table->string('authorized_person_title');
            $table->string('corporate_email');

            // Aranan personel
            $table->string('requested_position_title');
            $table->string('work_status');
            $table->unsignedInteger('personnel_count')->default(1);
            $table->string('work_location');
            $table->string('education_level')->nullable();
            $table->text('accepted_programs')->nullable();
            $table->string('profession_title')->nullable();
            $table->string('minimum_experience')->nullable();
            $table->text('job_description');
            $table->text('mandatory_conditions')->nullable();
            $table->text('preferred_conditions')->nullable();

            // Süre ve başvuru
            $table->date('deadline_date')->index();
            $table->string('application_channel');
            $table->string('additional_document_path')->nullable();
            $table->boolean('is_active')->default(true)->index();

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('hr_personnel_requests');
    }
};
