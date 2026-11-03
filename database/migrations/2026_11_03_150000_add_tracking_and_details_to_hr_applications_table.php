<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('hr_applications', function (Blueprint $table) {
            $table->string('tracking_number')->nullable()->unique()->after('id');
            $table->enum('status', ['Alındı', 'İnceleniyor', 'Ek Bilgi Bekleniyor', 'Sonuçlandı'])->default('Alındı')->index()->after('type');

            // İş / staj başvurusunun alt türü ve başvuru sahibinin temel bilgileri
            $table->enum('application_kind', ['is', 'staj'])->nullable()->after('status');
            $table->string('full_name')->nullable()->after('application_kind');
            $table->string('email')->nullable()->after('full_name');
            $table->string('phone', 30)->nullable()->after('email');

            $table->string('desired_position')->nullable();
            $table->text('location_preferences')->nullable();
            $table->text('experience_details')->nullable();
            $table->date('start_date')->nullable();
            $table->string('cv_path')->nullable();
            $table->string('portfolio_path')->nullable();

            $table->string('internship_school')->nullable();
            $table->string('internship_department')->nullable();
            $table->enum('internship_type', ['Zorunlu', 'İsteğe Bağlı'])->nullable();
            $table->date('internship_start_date')->nullable();
            $table->date('internship_end_date')->nullable();
            $table->string('school_documents_path')->nullable();

            $table->boolean('consent_accepted')->default(false);
        });
    }

    public function down(): void
    {
        Schema::table('hr_applications', function (Blueprint $table) {
            $table->dropUnique(['tracking_number']);
            $table->dropIndex(['status']);
            $table->dropColumn([
                'tracking_number', 'status', 'application_kind', 'full_name', 'email', 'phone',
                'desired_position', 'location_preferences', 'experience_details', 'start_date', 'cv_path', 'portfolio_path',
                'internship_school', 'internship_department', 'internship_type', 'internship_start_date', 'internship_end_date',
                'school_documents_path', 'consent_accepted',
            ]);
        });
    }
};
