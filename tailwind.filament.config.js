import preset from './vendor/filament/support/tailwind.config.preset';
import siteConfig from './tailwind.config.js';

/**
 * Ön yüzdeki Filament formları için ayrı derleme. Sitenin ana CSS'ine
 * @tailwindcss/forms taban stillerini eklememek için yalnızca bu sayfalarda yüklenir.
 */
export default {
    presets: [preset],
    content: [
        './app/Livewire/**/*.php',
        './resources/views/livewire/**/*.blade.php',
        './vendor/filament/**/*.blade.php',
    ],
    theme: siteConfig.theme,
};
