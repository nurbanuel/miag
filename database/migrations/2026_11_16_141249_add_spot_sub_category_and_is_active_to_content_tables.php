<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /** İçerik tabloları: Özet/Spot, alt kategori ve yayın (aktif/pasif) durumu. */
    private array $tables = ['articles', 'reports', 'news', 'policy_contents', 'events', 'announcements'];

    public function up(): void
    {
        foreach ($this->tables as $name) {
            Schema::table($name, function (Blueprint $table) use ($name) {
                if (! Schema::hasColumn($name, 'spot')) {
                    $table->text('spot')->nullable()->after('title');
                }
                if (! Schema::hasColumn($name, 'sub_category_id')) {
                    $table->foreignId('sub_category_id')->nullable()->after('category_id')->constrained('categories')->nullOnDelete();
                }
                if (! Schema::hasColumn($name, 'is_active')) {
                    $table->boolean('is_active')->default(true)->index();
                }
            });
        }

        // Mevcut özetler spot alanına taşınır (eski sütunlar korunur ve kayıtta eşitlenir).
        DB::table('articles')->whereNull('spot')->update(['spot' => DB::raw('excerpt')]);
        DB::table('policy_contents')->whereNull('spot')->update(['spot' => DB::raw('summary')]);
    }

    public function down(): void
    {
        foreach ($this->tables as $name) {
            Schema::table($name, function (Blueprint $table) {
                $table->dropConstrainedForeignId('sub_category_id');
                $table->dropColumn(['spot', 'is_active']);
            });
        }
    }
};
