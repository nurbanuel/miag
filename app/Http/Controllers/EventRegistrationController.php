<?php

namespace App\Http\Controllers;

use App\Models\Event;
use App\Models\EventRegistration;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;
use Illuminate\View\View;

/**
 * Etkinliğe özel kayıt formu. Herkese açıktır; üye girişi yapılmışsa bilgiler
 * otomatik doldurulur ve kayıt üyeyle (user_id) eşleştirilir.
 */
class EventRegistrationController extends Controller
{
    public function create(Event $event): View
    {
        return view('events.register', [
            'event' => $event,
            'registrationOpen' => $event->isRegistrationOpen(),
        ]);
    }

    public function store(Request $request, Event $event): RedirectResponse
    {
        if (! $event->isRegistrationOpen()) {
            return back()->withErrors(['event' => __('Bu etkinlik için kayıtlar kapanmıştır.')]);
        }

        // E-posta küçük harfe çevrilerek mükerrer kontrolü büyük/küçük harf farkından etkilenmez.
        $request->merge(['email' => Str::lower(trim((string) $request->input('email')))]);

        $data = $request->validate([
            'full_name' => ['required', 'string', 'max:150'],
            'institution' => ['required', 'string', 'max:200'],
            'department' => ['required', 'string', 'max:200'],
            'title' => ['required', 'string', 'max:150'],
            'email' => [
                'required', 'email', 'max:150',
                Rule::unique('event_registrations', 'email')->where('event_id', $event->id),
            ],
            'phone' => ['required', 'string', 'max:30', 'regex:/^[0-9+()\s-]{10,30}$/'],
            'is_mts_subscriber' => ['required', Rule::in(['1', '0'])],
        ], [
            'email.unique' => __('Bu e-posta adresiyle bu etkinliğe zaten kayıt yapılmış.'),
            'phone.regex' => __('Lütfen geçerli bir GSM numarası girin (ör. 0555 123 45 67).'),
            'is_mts_subscriber.required' => __('Lütfen MTS abonelik durumunuzu seçin.'),
        ], [
            'full_name' => __('Adı Soyadı'),
            'institution' => __('Kurumu'),
            'department' => __('Dairesi/Müdürlüğü'),
            'title' => __('Unvanı/Görevi'),
            'email' => __('E-posta Adresi'),
            'phone' => __('GSM Numarası'),
            'is_mts_subscriber' => __('MTS Abonesi mi?'),
        ]);

        $event->registrations()->create([
            ...$data,
            'is_mts_subscriber' => $data['is_mts_subscriber'] === '1',
            'user_id' => $request->user()?->id,
        ]);

        return redirect(lroute('events.register', $event))
            ->with('registered', __('Kaydınız alınmıştır, :name. ":event" etkinliğine ilişkin katılım bilgileri :email adresine iletilecektir.', [
                'name' => $data['full_name'],
                'event' => $event->title,
                'email' => $data['email'],
            ]));
    }
}
