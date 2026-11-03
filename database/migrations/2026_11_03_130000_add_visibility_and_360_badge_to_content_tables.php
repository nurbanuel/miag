<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    private array $tables = ['articles', 'news', 'reports', 'events', 'announcements', 'policy_contents'];

    public function up(): void
    {
        foreach ($this->tables as $table) {
            Schema::table($table, function (Blueprint $t) use ($table) {
                if (! Schema::hasColumn($table, 'visibility_start')) {
                    $t->dateTime('visibility_start')->nullable();
                }
                if (! Schema::hasColumn($table, 'visibility_end')) {
                    $t->dateTime('visibility_end')->nullable();
                }
                if (! Schema::hasColumn($table, 'has_360_badge')) {
                    $t->boolean('has_360_badge')->default(false);
                }
            });
        }
    }

    public function down(): void
    {
        foreach ($this->tables as $table) {
            Schema::table($table, fn (Blueprint $t) => $t->dropColumn(['visibility_start', 'visibility_end', 'has_360_badge']));
        }
    }
};
