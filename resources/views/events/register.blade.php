@php
$user = auth()->user();
$inputClass = 'w-full rounded-md border px-3.5 py-2.5 text-sm text-navy-900 focus-visible:outline focus-visible:outline-2 focus-visible:outline-turquoise-500';
$fields = [
    ['full_name', __('Adı Soyadı'), 'text', $user?->name, 'name'],
    ['institution', __('Kurumu'), 'text', null, 'organization'],
    ['department', __('Dairesi/Müdürlüğü'), 'text', null, null],
    ['title', __('Unvanı/Görevi'), 'text', null, 'organization-title'],
    ['email', __('E-posta Adresi'), 'email', $user?->email, 'email'],
    ['phone', __('GSM Numarası'), 'tel', $user?->phone, 'tel'],
];
@endphp

<x-layout :title="__('Etkinlik Kaydı').' — '.$event->title">
    <x-container class="py-12">
        <nav class="mb-6 text-sm text-navy-500" aria-label="{{ __('Sayfa konumu') }}">
            <a href="{{ lroute('events.index') }}" class="hover:text-turquoise-700">{{ __('Etkinlikler') }}</a>
            <span class="mx-1.5">/</span>
            <a href="{{ lroute('events.show', $event) }}" class="hover:text-turquoise-700">{{ \Illuminate\Support\Str::limit($event->title, 60) }}</a>
            <span class="mx-1.5">/</span>
            <span class="text-navy-800">{{ __('Kayıt') }}</span>
        </nav>

        <div class="mx-auto max-w-3xl">
            {{-- Etkinlik özet kartı --}}
            <div class="overflow-hidden rounded-2xl bg-[#0a1120] text-white shadow-sm">
                <div class="flex flex-col gap-5 p-6 sm:flex-row sm:items-center sm:p-8">
                    @if ($event->featured_image)
                        <img src="{{ asset('storage/'.$event->featured_image) }}" alt="" class="h-24 w-full rounded-lg object-cover sm:h-24 sm:w-36" />
                    @endif
                    <div class="min-w-0 flex-1">
                        <p class="text-xs font-semibold uppercase tracking-[0.2em] text-turquoise-300">{{ __('Etkinlik Kaydı') }}</p>
                        <h1 class="mt-2 text-2xl font-bold leading-snug sm:text-3xl">{{ $event->title }}</h1>
                        <dl class="mt-4 flex flex-wrap gap-x-6 gap-y-2 text-sm text-slate-300">
                            <div class="flex items-center gap-2">
                                <svg class="h-4 w-4 text-turquoise-300" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true"><path fill-rule="evenodd" d="M5.75 2a.75.75 0 01.75.75V4h7V2.75a.75.75 0 011.5 0V4h.25A2.75 2.75 0 0118 6.75v8.5A2.75 2.75 0 0115.25 18H4.75A2.75 2.75 0 012 15.25v-8.5A2.75 2.75 0 014.75 4H5V2.75A.75.75 0 015.75 2zm-1 5.5c-.69 0-1.25.56-1.25 1.25v6.5c0 .69.56 1.25 1.25 1.25h10.5c.69 0 1.25-.56 1.25-1.25v-6.5c0-.69-.56-1.25-1.25-1.25H4.75z" clip-rule="evenodd" /></svg>
                                <dt class="sr-only">{{ __('Tarih') }}</dt>
                                <dd>{{ $event->starts_at?->translatedFormat('d F Y, l · H:i') }}</dd>
                            </div>
                            @if ($event->location)
                                <div class="flex items-center gap-2">
                                    <svg class="h-4 w-4 text-turquoise-300" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true"><path fill-rule="evenodd" d="M9.69 18.933l.003.001C9.89 19.02 10 19 10 19s.11.02.308-.066l.002-.001.006-.003.018-.008a5.741 5.741 0 00.281-.14c.186-.096.446-.24.757-.433.62-.384 1.445-.966 2.274-1.765C15.302 14.988 17 12.493 17 9A7 7 0 103 9c0 3.492 1.698 5.988 3.355 7.584a13.731 13.731 0 002.273 1.765 11.842 11.842 0 00.976.544l.062.029.018.008.006.003zM10 11.25a2.25 2.25 0 100-4.5 2.25 2.25 0 000 4.5z" clip-rule="evenodd" /></svg>
                                    <dt class="sr-only">{{ __('Yer') }}</dt>
                                    <dd>{{ $event->location }}</dd>
                                </div>
                            @endif
                        </dl>
                    </div>
                </div>
            </div>

            @if (session('registered'))
                <div class="mt-8 rounded-2xl border border-turquoise-200 bg-turquoise-50 p-6 text-turquoise-900" role="status">
                    <div class="flex items-start gap-3">
                        <svg class="mt-0.5 h-6 w-6 shrink-0 text-turquoise-600" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true"><path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.857-9.809a.75.75 0 00-1.214-.882l-3.483 4.79-1.88-1.88a.75.75 0 10-1.06 1.061l2.5 2.5a.75.75 0 001.137-.089l4-5.5z" clip-rule="evenodd" /></svg>
                        <div>
                            <p class="font-semibold">{{ __('Kaydınız başarıyla alındı.') }}</p>
                            <p class="mt-1 text-sm">{{ session('registered') }}</p>
                            <a href="{{ lroute('events.show', $event) }}" class="mt-3 inline-block text-sm font-semibold text-turquoise-800 underline">{{ __('Etkinlik sayfasına dön') }}</a>
                        </div>
                    </div>
                </div>
            @elseif (! $registrationOpen)
                <x-alert tone="error" class="mt-8">{{ __('Bu etkinlik için kayıtlar kapanmıştır.') }}</x-alert>
            @else
                <div class="mt-8 rounded-2xl border border-navy-100 bg-white p-6 shadow-sm sm:p-8">
                    <div class="flex flex-wrap items-start justify-between gap-3">
                        <h2 class="text-xl font-bold text-navy-900">{{ __('Katılımcı Bilgileri') }}</h2>
                        @auth
                            <span class="rounded-full bg-turquoise-50 px-3 py-1 text-xs font-medium text-turquoise-800">{{ __('Üye bilgileriniz otomatik dolduruldu') }}</span>
                        @else
                            <span class="text-xs text-navy-500">
                                {{ __('Üye misiniz?') }}
                                <a href="{{ lroute('member.login') }}" class="font-semibold text-turquoise-700 hover:underline">{{ __('Giriş yapın') }}</a>
                                {{ __('— bilgileriniz otomatik dolsun.') }}
                            </span>
                        @endauth
                    </div>
                    <p class="mt-1 text-sm text-navy-500">{{ __('Tüm alanların doldurulması zorunludur.') }}</p>

                    @error('event')
                        <x-alert tone="error" class="mt-4">{{ $message }}</x-alert>
                    @enderror

                    <form method="POST" action="{{ lroute('events.register.store', $event) }}" class="mt-6 grid gap-5 sm:grid-cols-2" novalidate>
                        @csrf
                        @foreach ($fields as [$name, $label, $type, $default, $autocomplete])
                            <div @class(['sm:col-span-2' => $name === 'full_name'])>
                                <label for="{{ $name }}" class="mb-1.5 block text-sm font-medium text-navy-800">{{ $label }} <span class="text-bordo-600">*</span></label>
                                <input
                                    type="{{ $type }}"
                                    id="{{ $name }}"
                                    name="{{ $name }}"
                                    value="{{ old($name, $default) }}"
                                    required
                                    maxlength="{{ $name === 'phone' ? 30 : 200 }}"
                                    @if ($autocomplete) autocomplete="{{ $autocomplete }}" @endif
                                    @if ($name === 'phone') placeholder="05xx xxx xx xx" inputmode="tel" @endif
                                    class="{{ $inputClass }} {{ $errors->has($name) ? 'border-bordo-400' : 'border-navy-200' }}"
                                />
                                @error($name)
                                    <p class="mt-1.5 text-sm text-bordo-600">{{ $message }}</p>
                                @enderror
                            </div>
                        @endforeach

                        <fieldset class="sm:col-span-2">
                            <legend class="mb-2 block text-sm font-medium text-navy-800">{{ __('MTS Abonesi mi?') }} <span class="text-bordo-600">*</span></legend>
                            <div class="flex flex-wrap gap-3">
                                @foreach (['1' => __('Evet'), '0' => __('Hayır')] as $value => $label)
                                    <label class="flex cursor-pointer items-center gap-2 rounded-lg border px-4 py-2.5 text-sm text-navy-800 has-[:checked]:border-turquoise-500 has-[:checked]:bg-turquoise-50 {{ $errors->has('is_mts_subscriber') ? 'border-bordo-400' : 'border-navy-200' }}">
                                        <input type="radio" name="is_mts_subscriber" value="{{ $value }}" required class="h-4 w-4 text-turquoise-600 focus:ring-turquoise-500" @checked(old('is_mts_subscriber') === (string) $value) />
                                        {{ $label }}
                                    </label>
                                @endforeach
                            </div>
                            <p class="mt-1.5 text-xs text-navy-500">{{ __('MİARGEM Mevzuat Takip Sistemi (MTS) aboneliği.') }}</p>
                            @error('is_mts_subscriber')
                                <p class="mt-1.5 text-sm text-bordo-600">{{ $message }}</p>
                            @enderror
                        </fieldset>

                        <div class="sm:col-span-2">
                            <button type="submit" class="w-full rounded-lg bg-[#8b1e3f] px-5 py-3 text-sm font-semibold text-white hover:bg-[#721833] focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-[#8b1e3f] sm:w-auto sm:px-8">
                                {{ __('Kaydımı Tamamla') }}
                            </button>
                        </div>
                    </form>
                </div>
            @endif

            @include('events.partials.notice')
        </div>
    </x-container>
</x-layout>
