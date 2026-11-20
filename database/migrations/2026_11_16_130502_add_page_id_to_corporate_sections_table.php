<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Kurumsal bölümleri "Sayfalar > Kurumsal" kaydına bağlanır; böylece sayfa düzenleme
     * ekranından ilişki (relationship) repeater'ı ile yönetilebilir.
     */
    public function up(): void
    {
        Schema::table('corporate_sections', function (Blueprint $table) {
            $table->foreignId('page_id')->nullable()->after('id')->constrained('pages')->nullOnDelete();
        });

        $pageId = DB::table('pages')->where('slug', 'kurumsal')->value('id');
        if ($pageId) {
            DB::table('corporate_sections')->update(['page_id' => $pageId]);
        }
    }

    public function down(): void
    {
        Schema::table('corporate_sections', function (Blueprint $table) {
            $table->dropConstrainedForeignId('page_id');
        });
    }
};
