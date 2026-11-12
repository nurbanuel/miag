<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    private array $columns = ['header_menu', 'footer_quick_links', 'footer_legal_links'];

    /**
     * Veri - Gözlemevi sayfası kaldırıldı; menülerdeki bağlantıları (alt menüler dahil) temizlenir.
     * Diğer menü öğelerine dokunulmaz.
     */
    public function up(): void
    {
        if (! Schema::hasTable('site_settings')) {
            return;
        }

        foreach (DB::table('site_settings')->get() as $row) {
            $changes = [];

            foreach ($this->columns as $column) {
                $items = json_decode((string) ($row->{$column} ?? ''), true);
                if (! is_array($items)) {
                    continue;
                }

                $cleaned = $this->withoutObservatory($items);
                if ($cleaned !== $items) {
                    $changes[$column] = json_encode($cleaned, JSON_UNESCAPED_UNICODE);
                }
            }

            if ($changes) {
                DB::table('site_settings')->where('id', $row->id)->update($changes);
            }
        }
    }

    public function down(): void
    {
        // Kaldırılan menü bağlantıları geri eklenmez.
    }

    private function withoutObservatory(array $items): array
    {
        $result = [];

        foreach ($items as $item) {
            if (is_array($item) && str_contains((string) ($item['url'] ?? ''), 'veri-ve-gozlemevi')) {
                continue;
            }

            if (is_array($item) && isset($item['children']) && is_array($item['children'])) {
                $item['children'] = $this->withoutObservatory($item['children']);
            }

            $result[] = $item;
        }

        return $result;
    }
};
