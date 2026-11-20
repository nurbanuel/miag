<?php

namespace App\Support;

/**
 * Trix editörü hizalamayı özel blok etiketleriyle (<align-center> vb.) tutar.
 * Veritabanına standart HTML (<div style="text-align: center;">) yazılır; editöre
 * yüklenirken geri dönüştürülür. Böylece ön yüz ek CSS gerektirmeden hizalamayı gösterir.
 */
class RichTextAlignment
{
    public const ALIGNMENTS = ['left', 'center', 'right', 'justify'];

    /** Editör etiketleri -> kayıt HTML'i */
    public static function toStorage(?string $html): ?string
    {
        if (blank($html)) {
            return $html;
        }

        $html = preg_replace('/<align-('.implode('|', self::ALIGNMENTS).')>/i', '<div style="text-align: $1;">', $html);

        return preg_replace('/<\/align-(?:'.implode('|', self::ALIGNMENTS).')>/i', '</div>', $html);
    }

    /** Kayıt HTML'i -> editör etiketleri */
    public static function toEditor(?string $html): ?string
    {
        if (blank($html) || ! str_contains($html, 'text-align')) {
            return $html;
        }

        $dom = new \DOMDocument('1.0', 'UTF-8');
        $previous = libxml_use_internal_errors(true);
        $dom->loadHTML('<?xml encoding="UTF-8"><div id="__root">'.$html.'</div>', LIBXML_HTML_NOIMPLIED | LIBXML_HTML_NODEFDTD);
        libxml_clear_errors();
        libxml_use_internal_errors($previous);

        $xpath = new \DOMXPath($dom);
        $nodes = iterator_to_array($xpath->query('//*[@style][contains(translate(@style, "TEXTALIGN", "textalign"), "text-align")]'));

        foreach ($nodes as $node) {
            if (! preg_match('/text-align\s*:\s*(left|center|right|justify)/i', $node->getAttribute('style'), $m)) {
                continue;
            }

            $align = strtolower($m[1]);

            if (in_array(strtolower($node->nodeName), ['div', 'p'], true)) {
                // Paragraf/blok: doğrudan hizalama bloğuna dönüştürülür.
                $replacement = $dom->createElement('align-'.$align);
                while ($node->firstChild) {
                    $replacement->appendChild($node->firstChild);
                }
                $node->parentNode->replaceChild($replacement, $node);
            } else {
                // Başlık vb.: öğe dıştan hizalama bloğuyla sarılır (<align-center><h2>…</h2></align-center>).
                $wrapper = $dom->createElement('align-'.$align);
                $node->parentNode->replaceChild($wrapper, $node);
                $node->removeAttribute('style');
                $wrapper->appendChild($node);
            }
        }

        $root = $dom->getElementById('__root') ?? $xpath->query('//div[@id="__root"]')->item(0);
        $out = '';
        foreach ($root->childNodes as $child) {
            $out .= $dom->saveHTML($child);
        }

        return $out;
    }
}
