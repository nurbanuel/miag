<?php

namespace App\Http\Controllers;

use Illuminate\View\View;

class ObservatoryController extends Controller
{
    public function index(): View
    {
        // Örnek il bazlı gösterge verisi. İleride gerçek veri kaynağıyla değiştirilecektir.
        $provinces = [
            ['name' => 'İstanbul', 'lat' => 41.0082, 'lng' => 28.9784, 'ozGelirOrani' => 62],
            ['name' => 'Ankara', 'lat' => 39.9334, 'lng' => 32.8597, 'ozGelirOrani' => 58],
            ['name' => 'İzmir', 'lat' => 38.4237, 'lng' => 27.1428, 'ozGelirOrani' => 55],
            ['name' => 'Kırklareli', 'lat' => 41.7333, 'lng' => 27.2167, 'ozGelirOrani' => 47],
            ['name' => 'Bursa', 'lat' => 40.1826, 'lng' => 29.0665, 'ozGelirOrani' => 51],
            ['name' => 'Antalya', 'lat' => 36.8969, 'lng' => 30.7133, 'ozGelirOrani' => 60],
        ];

        return view('observatory.index', compact('provinces'));
    }
}
