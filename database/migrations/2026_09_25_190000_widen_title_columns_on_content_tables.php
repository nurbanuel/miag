<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    // WordPress'ten gelen bazı mevzuat başlıkları 255 karakteri aşıyor (en uzunu ~630).
    private array $tables = ['news', 'articles', 'policy_contents', 'reports', 'events', 'announcements'];

    public function up(): void
    {
        foreach ($this->tables as $table) {
            Schema::table($table, fn (Blueprint $t) => $t->text('title')->change());
        }
    }

    public function down(): void
    {
        foreach ($this->tables as $table) {
            Schema::table($table, fn (Blueprint $t) => $t->string('title')->change());
        }
    }
};
