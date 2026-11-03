<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Str;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('announcements', function (Blueprint $table) {
            $table->string('slug')->nullable()->unique()->after('title');
        });

        // Mevcut duyurular için başlıktan benzersiz slug üretilir.
        $used = [];
        foreach (DB::table('announcements')->orderBy('id')->get(['id', 'title']) as $row) {
            $base = rtrim(Str::limit(Str::slug((string) $row->title), 200, ''), '-') ?: 'duyuru';
            $slug = $base;
            $i = 2;
            while (in_array($slug, $used, true)) {
                $slug = $base.'-'.$i++;
            }
            $used[] = $slug;
            DB::table('announcements')->where('id', $row->id)->update(['slug' => $slug]);
        }
    }

    public function down(): void
    {
        Schema::table('announcements', function (Blueprint $table) {
            $table->dropUnique(['slug']);
            $table->dropColumn('slug');
        });
    }
};
