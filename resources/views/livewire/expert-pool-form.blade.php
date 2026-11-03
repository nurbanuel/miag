<div class="fi-frontend-form">
    @if ($submitted)
        <div role="status" class="mb-6 rounded-xl border border-emerald-200 bg-emerald-50 p-5 text-emerald-900">
            <p class="font-semibold">{{ __('Havuz kaydınız alındı.') }}</p>
            <p class="mt-1 text-sm">{{ __('Katkı alanlarınıza uygun bir çalışma olduğunda sizinle iletişime geçilecektir.') }}</p>
        </div>
    @endif

    <form wire:submit="submit" class="space-y-6">
        {{ $this->form }}

        <button type="submit" wire:loading.attr="disabled" class="inline-flex w-full items-center justify-center gap-2 rounded-lg bg-bordo-700 px-5 py-3 text-sm font-semibold text-white hover:bg-bordo-800 disabled:opacity-60">
            <span wire:loading.remove wire:target="submit">{{ __('Havuza Kaydol') }}</span>
            <span wire:loading wire:target="submit">{{ __('Gönderiliyor...') }}</span>
        </button>
    </form>
</div>
