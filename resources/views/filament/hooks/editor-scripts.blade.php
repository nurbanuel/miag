<script>
    /*
     * Trix editörüne hizalama (sola / ortala / sağa / iki yana) ve "Paragraf" butonları eklenir.
     * Hizalama, Trix'te özel blok etiketleriyle (<align-center> vb.) tutulur; sunucu tarafında
     * standart <div style="text-align: center;"> HTML'ine dönüştürülür (App\Support\RichTextAlignment).
     */
    (() => {
        const ALIGNMENTS = [
            { key: 'alignLeft', tag: 'align-left', title: 'Sola Yasla', icon: 'M3 5h14M3 9h9M3 13h14M3 17h9' },
            { key: 'alignCenter', tag: 'align-center', title: 'Ortala', icon: 'M3 5h14M5.5 9h9M3 13h14M5.5 17h9' },
            { key: 'alignRight', tag: 'align-right', title: 'Sağa Yasla', icon: 'M3 5h14M8 9h9M3 13h14M8 17h9' },
            { key: 'alignJustify', tag: 'align-justify', title: 'İki Yana Yasla', icon: 'M3 5h14M3 9h14M3 13h14M3 17h14' },
        ];
        const BLOCK_FORMATS = ['heading1', 'heading', 'subHeading', 'quote', 'code'];

        document.addEventListener('trix-before-initialize', () => {
            const config = window.Trix?.config?.blockAttributes;
            if (! config || config.alignCenter) return;

            ALIGNMENTS.forEach(({ key, tag }) => {
                config[key] = { tagName: tag, breakOnReturn: true, group: false };
            });

            // Trix, yüklenen HTML'i DOMPurify ile temizler; hizalama etiketlerinin korunması için izin verilir.
            const purify = window.Trix.config.dompurify;
            if (purify) {
                purify.ADD_TAGS = [...new Set([...(purify.ADD_TAGS || []), ...ALIGNMENTS.map((a) => a.tag)])];
            }
        });

        const buttonClasses = 'fi-fo-rich-editor-toolbar-btn flex h-8 min-w-[theme(spacing.8)] cursor-pointer items-center justify-center rounded-lg text-sm font-semibold text-gray-700 transition duration-75 hover:bg-gray-50 focus-visible:bg-gray-50 dark:text-gray-200 dark:hover:bg-white/5 dark:focus-visible:bg-white/5 [&.trix-active]:bg-gray-50 [&.trix-active]:text-primary-600 dark:[&.trix-active]:bg-white/5 dark:[&.trix-active]:text-primary-400';

        const makeButton = (title, inner, attrs = {}) => {
            const button = document.createElement('button');
            button.type = 'button';
            button.tabIndex = -1;
            button.title = title;
            button.setAttribute('aria-label', title);
            button.className = buttonClasses;
            Object.entries(attrs).forEach(([k, v]) => button.setAttribute(k, v));
            button.innerHTML = inner;
            return button;
        };

        const svg = (path) => `<svg class="h-5 w-5" viewBox="0 0 20 20" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" aria-hidden="true"><path d="${path}"/></svg>`;

        document.addEventListener('trix-initialize', (event) => {
            const editorElement = event.target;
            const toolbar = editorElement.toolbarElement;
            if (! toolbar || toolbar.querySelector('[data-miargem-align-tools]')) return;

            const row = toolbar.querySelector(':scope > div') ?? toolbar;
            const editor = () => editorElement.editor;
            // İmlecin bulunduğu bloğun tüm nitelikleri (iç içe başlık + hizalama dahil).
            const blockAttributes = () => {
                const ed = editor();
                if (! ed) return [];
                const [start] = ed.getSelectedRange();
                return ed.getDocument().getBlockAtPosition(start)?.getAttributes() ?? [];
            };

            // Paragraf: başlık / alıntı biçimini kaldırıp düz paragrafa döndürür.
            const blockGroup = document.createElement('div');
            blockGroup.className = 'flex gap-x-1';
            blockGroup.setAttribute('data-miargem-block-tools', '');
            const paragraph = makeButton('Paragraf', '<span class="px-1 text-sm font-bold">¶</span>');
            paragraph.addEventListener('mousedown', (e) => {
                e.preventDefault();
                BLOCK_FORMATS.forEach((attr) => {
                    if (editor().attributeIsActive(attr)) editor().deactivateAttribute(attr);
                });
            });
            blockGroup.appendChild(paragraph);

            // Hizalama butonları. Trix başlığı "terminal" blok saydığı için hizalama başlığın dışına
            // uygulanır: başlık geçici olarak kaldırılır, hizalama eklenir, başlık geri eklenir.
            const alignGroup = document.createElement('div');
            alignGroup.className = 'flex gap-x-1';
            alignGroup.setAttribute('data-miargem-align-tools', '');
            const alignButtons = ALIGNMENTS.map(({ key, title, icon }) => {
                const button = makeButton(title, svg(icon), { 'data-miargem-align': key });
                button.addEventListener('mousedown', (e) => {
                    e.preventDefault();
                    const ed = editor();
                    const attrs = blockAttributes();
                    const wasActive = attrs.includes(key);
                    const heading = BLOCK_FORMATS.find((attr) => attrs.includes(attr));

                    ed.recordUndoEntry('Hizalama');
                    if (heading) ed.deactivateAttribute(heading);
                    ALIGNMENTS.forEach((other) => {
                        if (attrs.includes(other.key)) ed.deactivateAttribute(other.key);
                    });
                    if (! wasActive) ed.activateAttribute(key);
                    if (heading) ed.activateAttribute(heading);
                    refreshAlignState();
                });
                alignGroup.appendChild(button);
                return button;
            });

            const refreshAlignState = () => {
                const attrs = blockAttributes();
                alignButtons.forEach((button) => {
                    button.classList.toggle('trix-active', attrs.includes(button.dataset.miargemAlign));
                });
            };
            editorElement.addEventListener('trix-selection-change', refreshAlignState);
            editorElement.addEventListener('trix-change', refreshAlignState);

            const separator = () => {
                const s = document.createElement('span');
                s.className = 'miargem-toolbar-separator';
                s.setAttribute('aria-hidden', 'true');
                return s;
            };

            // Başlık grubunun (H2/H3) yanına yerleştirilir; bulunamazsa sona eklenir.
            const headingGroup = toolbar.querySelector('[data-trix-attribute="heading"]')?.parentElement;
            if (headingGroup && headingGroup.parentElement === row) {
                headingGroup.after(blockGroup);
                blockGroup.after(alignGroup);
            } else {
                row.append(separator(), blockGroup, alignGroup);
            }
        });
    })();
</script>
