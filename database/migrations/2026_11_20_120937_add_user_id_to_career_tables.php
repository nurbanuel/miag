<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /** İK ve Kariyer formlarının yazdığı tablolar: kaydı oluşturan üye. */
    private array $tables = [
        'hr_personnel_requests',
        'hr_applications',
        'municipal_staff_requests',
        'transfer_network_profiles',
        'job_internship_applications',
        'expert_pool_profiles',
    ];

    public function up(): void
    {
        foreach ($this->tables as $name) {
            if (Schema::hasTable($name) && ! Schema::hasColumn($name, 'user_id')) {
                Schema::table($name, function (Blueprint $table) {
                    $table->foreignId('user_id')->nullable()->after('id')->constrained()->nullOnDelete();
                });
            }
        }
    }

    public function down(): void
    {
        foreach ($this->tables as $name) {
            if (Schema::hasColumn($name, 'user_id')) {
                Schema::table($name, fn (Blueprint $table) => $table->dropConstrainedForeignId('user_id'));
            }
        }
    }
};
