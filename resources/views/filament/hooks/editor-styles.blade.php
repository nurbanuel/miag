<style>
    /* ---- Metin editörü: sabit araç çubuğu + sabit yükseklikli, kaydırılabilir yazı alanı ---- */

    /* Dış kapsayıcı taşmayı kesmesin; aksi hâlde sticky araç çubuğu çalışmaz. */
    .fi-fo-rich-editor,
    .fi-fo-rich-editor > div {
        overflow: visible !important;
    }

    /* Araç çubuğu: sayfa kaydırıldığında üstte sabit kalır (Filament üst barının hemen altında). */
    .fi-fo-rich-editor trix-toolbar {
        position: sticky;
        top: 4rem;
        z-index: 20;
        background-color: #ffffff;
        border-bottom: 1px solid #e5e7eb;
        padding-top: 0.5rem;
        padding-bottom: 0.5rem;
        border-top-left-radius: 0.5rem;
        border-top-right-radius: 0.5rem;
    }
    .dark .fi-fo-rich-editor trix-toolbar {
        background-color: rgb(24 24 27);
        border-bottom-color: rgb(255 255 255 / 0.1);
    }
    /* Butonlar dar ekranda alt satıra geçsin (yatay kaydırma yerine). */
    .fi-fo-rich-editor trix-toolbar > div:first-child {
        flex-wrap: wrap;
        row-gap: 0.25rem;
        overflow-x: visible !important;
    }

    /* İçerik editörleri: standart yükseklik, kendi içinde kaydırma. */
    .miargem-content-editor trix-editor {
        min-height: 380px !important;
        max-height: 450px;
        overflow-y: auto;
    }

    /* Hizalama blokları (editör içinde; kayıtta <div style="text-align: ..."> olur). */
    /* Global display:block — Trix, kayıtlı HTML'i ayrıştırırken blok öğeyi buna göre tanır. */
    align-left,
    align-center,
    align-right,
    align-justify { display: block; }
    trix-editor align-left { text-align: left; }
    trix-editor align-center { text-align: center; }
    trix-editor align-right { text-align: right; }
    trix-editor align-justify { text-align: justify; }

    .miargem-toolbar-separator {
        width: 1px;
        align-self: stretch;
        background-color: rgb(229 231 235);
    }
    .dark .miargem-toolbar-separator { background-color: rgb(255 255 255 / 0.1); }
</style>
