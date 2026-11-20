<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Üst menü: "Başkanın Mesajı" kaldırılır, "Başkanın Özgeçmişi" -> "Başkan" (/baskan),
     * "Yazılar" öğesinin ardına "Vatandaş Rehberi" (alt menülü) eklenir.
     */
    public function up(): void
    {
        if (! Schema::hasTable('site_settings')) {
            return;
        }

        $citizenGuide = [
            'title' => 'Vatandaş Rehberi',
            'url' => '/vatandas-rehberi',
            'children' => [
                ['title' => 'Vatandaş Rehberi', 'url' => '/vatandas-rehberi/rehber'],
                ['title' => 'Bunları Biliyor Musunuz?', 'url' => '/vatandas-rehberi/bunlari-biliyor-musunuz'],
            ],
        ];

        foreach (DB::table('site_settings')->get() as $row) {
            $items = json_decode((string) ($row->header_menu ?? ''), true);
            if (! is_array($items)) {
                continue;
            }

            $result = [];
            $hasGuide = collect($items)->contains(fn ($i) => ($i['url'] ?? null) === '/vatandas-rehberi');

            foreach ($items as $item) {
                $url = $item['url'] ?? '';

                if ($url === '/baskanin-mesaji') {
                    continue;
                }

                if ($url === '/ozgecmis') {
                    $item['title'] = 'Başkan';
                    $item['url'] = '/baskan';
                }

                $result[] = $item;

                if ($url === '/yazilar' && ! $hasGuide) {
                    $result[] = $citizenGuide;
                    $hasGuide = true;
                }
            }

            if (! $hasGuide) {
                $result[] = $citizenGuide;
            }

            DB::table('site_settings')->where('id', $row->id)->update([
                'header_menu' => json_encode($result, JSON_UNESCAPED_UNICODE),
            ]);
        }
    }

    public function down(): void
    {
        //
    }
};
