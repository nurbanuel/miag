<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        // MİARGEM Uzman ve Araştırmacı Havuzu — İK tablolarından tamamen bağımsızdır.
        Schema::create('expert_pools', function (Blueprint $table) {
            $table->id();

            // Temel profil
            $table->string('full_name');
            $table->string('email')->index();
            $table->string('phone', 30)->nullable();
            $table->string('current_institution')->nullable();
            $table->string('actual_duty')->nullable();
            $table->string('unit')->nullable();
            $table->text('expertise_summary');

            // Eğitim ve akademik bilgi
            $table->string('education_level');
            $table->string('university');
            $table->string('faculty')->nullable();
            $table->string('department');
            $table->unsignedSmallInteger('graduation_year')->nullable();
            $table->string('profession_title');
            $table->string('academic_title')->nullable();
            $table->string('academic_duty')->nullable();

            // Uzmanlık ve katkı
            $table->json('expertise_areas');
            $table->json('contribution_types');

            // Deneyim ve üretimler
            $table->string('total_experience');
            $table->string('local_gov_experience');
            $table->json('experience_links')->nullable();

            // Yetkinlik ve uygunluk
            $table->json('foreign_languages')->nullable();
            $table->text('digital_tools')->nullable();
            $table->string('contribution_period');
            $table->string('work_format');
            $table->string('cv_path')->nullable();
            $table->boolean('profile_visibility')->default(false);

            // Yönetici alanları (adayla paylaşılmaz)
            $table->string('status')->default('Bekliyor')->index();
            $table->text('evaluation_notes')->nullable();

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('expert_pools');
    }
};
