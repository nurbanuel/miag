<div class="fi-frontend-form">
    @if ($trackingNumber)
        <div role="status" class="mb-6 rounded-xl border border-emerald-200 bg-emerald-50 p-5 text-emerald-900">
            <p class="font-semibold">{{ __('Başvurunuz alındı.') }}</p>
            <p class="mt-1 text-sm">
                {{ __('Takip numaranız:') }}
                <span class="font-mono font-bold tracking-wide">{{ $trackingNumber }}</span>
            </p>
            <p class="mt-1 text-xs text-emerald-800/80">{{ __('Başvurunuzla ilgili iletişimde bu numarayı kullanabilirsiniz.') }}</p>
        </div>
    @endif

    <form wire:submit="submit" class="space-y-6">
        {{ $this->form }}

        @if (filled($data['application_kind'] ?? null))
            <button type="submit" wire:loading.attr="disabled" class="inline-flex w-full items-center justify-center gap-2 rounded-lg bg-bordo-700 px-5 py-3 text-sm font-semibold text-white hover:bg-bordo-800 disabled:opacity-60">
                <span wire:loading.remove wire:target="submit">{{ __('Başvuruyu Gönder') }}</span>
                <span wire:loading wire:target="submit">{{ __('Gönderiliyor...') }}</span>
            </button>
        @endif
    </form>
</div>
