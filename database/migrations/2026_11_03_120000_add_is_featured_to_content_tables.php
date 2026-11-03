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
            if (! Schema::hasColumn($table, 'is_featured')) {
                Schema::table($table, fn (Blueprint $t) => $t->boolean('is_featured')->default(false)->index());
            }
        }
    }

    public function down(): void
    {
        foreach ($this->tables as $table) {
            if (Schema::hasColumn($table, 'is_featured')) {
                Schema::table($table, function (Blueprint $t) {
                    $t->dropIndex(['is_featured']);
                    $t->dropColumn('is_featured');
                });
            }
        }
    }
};
