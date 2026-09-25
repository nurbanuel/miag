<?php

use App\Models\Category;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    private array $tables = ['articles', 'announcements', 'events', 'reports', 'policy_contents'];

    public function up(): void
    {
        // Eski metin tabanlı kategori sütunu, yeni ilişkiyle karışmasın diye yeniden adlandırılır.
        foreach (['reports', 'announcements'] as $table) {
            if (Schema::hasColumn($table, 'category')) {
                // MariaDB < 10.5 yeniden adlandırmayı CHANGE ile yapar ve metin varsayılanını ('Duyuru')
                // hatalı tırnaklar; bu yüzden varsayılan önce kaldırılır (sütun zaten nullable olacak).
                DB::statement("ALTER TABLE `{$table}` ALTER COLUMN `category` DROP DEFAULT");
                Schema::table($table, fn (Blueprint $t) => $t->renameColumn('category', 'category_label'));
                Schema::table($table, fn (Blueprint $t) => $t->string('category_label')->nullable()->change());
            }
        }

        foreach ($this->tables as $table) {
            if (! Schema::hasColumn($table, 'category_id')) {
                Schema::table($table, function (Blueprint $t) {
                    $t->foreignId('category_id')->nullable()->constrained()->nullOnDelete();
                });
            }
        }

        // Mevcut metin kategorileri Category kayıtlarına taşınır.
        foreach (['reports', 'announcements'] as $table) {
            foreach (DB::table($table)->whereNotNull('category_label')->distinct()->pluck('category_label') as $label) {
                $category = Category::firstOrCreate(['name' => $label]);
                DB::table($table)->where('category_label', $label)->update(['category_id' => $category->id]);
            }
        }
    }

    public function down(): void
    {
        foreach ($this->tables as $table) {
            Schema::table($table, function (Blueprint $t) {
                $t->dropConstrainedForeignId('category_id');
            });
        }

        foreach (['reports', 'announcements'] as $table) {
            Schema::table($table, fn (Blueprint $t) => $t->renameColumn('category_label', 'category'));
        }
    }
};
