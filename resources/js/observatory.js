import L from 'leaflet';
import 'leaflet/dist/leaflet.css';

window.initObservatoryMap = function (elementId, points) {
    const map = L.map(elementId).setView([39.0, 35.0], 6);

    L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
        attribution: '&copy; OpenStreetMap katkıda bulunanlar',
        maxZoom: 18,
    }).addTo(map);

    points.forEach((point) => {
        L.circleMarker([point.lat, point.lng], {
            radius: 8 + point.ozGelirOrani / 8,
            color: '#128884',
            weight: 2,
            fillColor: '#17a29b',
            fillOpacity: 0.55,
        })
            .addTo(map)
            .bindPopup(`<strong>${point.name}</strong><br/>Öz Gelir Oranı: %${point.ozGelirOrani}`);
    });
};
