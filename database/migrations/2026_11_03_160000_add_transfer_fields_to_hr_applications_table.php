<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('hr_applications', function (Blueprint $table) {
            $table->string('current_institution')->nullable();
            $table->string('service_class')->nullable();
            $table->string('degree')->nullable();
            $table->string('total_service_time')->nullable();
            $table->string('current_institution_time')->nullable();
            $table->string('local_gov_experience')->nullable();
            $table->text('expertise_areas')->nullable();
            $table->text('transfer_reason')->nullable();
            $table->boolean('share_current_institution')->default(false);
            $table->boolean('share_contact_info')->default(false);
            $table->boolean('is_active')->default(true)->index();
            $table->string('communication_stage')->nullable();
            $table->string('evaluation_stage')->nullable();
        });

        // Nakil tercihleri öncelik sırasıyla ayrı tabloda tutulur.
        Schema::create('hr_transfer_preferences', function (Blueprint $table) {
            $table->id();
            $table->foreignId('hr_application_id')->constrained()->cascadeOnDelete();
            $table->unsignedSmallInteger('sort_order')->default(0);
            $table->string('province');
            $table->string('district')->nullable();
            $table->string('institution')->nullable();
            $table->string('position')->nullable();
            $table->date('available_from')->nullable();
            $table->date('available_until')->nullable();
            $table->timestamps();

            $table->index(['hr_application_id', 'sort_order']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('hr_transfer_preferences');

        Schema::table('hr_applications', function (Blueprint $table) {
            $table->dropIndex(['is_active']);
            $table->dropColumn([
                'current_institution', 'service_class', 'degree', 'total_service_time', 'current_institution_time',
                'local_gov_experience', 'expertise_areas', 'transfer_reason', 'share_current_institution',
                'share_contact_info', 'is_active', 'communication_stage', 'evaluation_stage',
            ]);
        });
    }
};
