<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Models\Car;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;

class ChatbotController extends Controller
{
    private const SHOWROOM_ADDRESS = 'Pekapuran Jl 1000 RT 06/05 NO 200 SUKAMAJU BARU TAPOS, DEPOK';

    private const SHOWROOM_MAPS_URL = 'https://maps.app.goo.gl/DfuVx5fYPCajf7Rk8';

    /** Tampilan manusia; link chat pakai wa.me dengan angka internasional. */
    private const WHATSAPP_DISPLAY = '62 895-3888-70708';

    private const WHATSAPP_WA_ME_URL = 'https://wa.me/62895388870708';

    /** Placeholder diganti di frontend menjadi tombol "Klik di sini" menuju WhatsApp. */
    private const WHATSAPP_CTA_PLACEHOLDER = '[WA_CTA]';

    public function chat(Request $request)
    {
        $request->validate(['message' => 'required|string']);

        $userMessage = $request->input('message');
        $history     = $request->input('history', []);

        $cars = Car::with('mainPhoto')
            ->where('status', 'available')
            ->limit(10) // batasi agar tidak terlalu banyak token
            ->get()
            ->map(fn($car) => [
                'id'            => $car->id,   
                'url'           => route('web.detailMobil', $car->id),
                'brand'         => $car->brand,
                'model'         => $car->model,
                'year'          => $car->year,
                'price'         => 'Rp ' . number_format($car->price, 0, ',', '.'),
                'transmission'  => $car->transmission,
                'description'   => $car->description,
                'service_history' => $car->service_history,
                'fuel_type'     => $car->fuel_type,
                'mileage'       => $car->mileage, 
                'color'         => $car->color,
                'tax'           => $car->tax,
                'engine'        => $car->engine,
                'seat'          => $car->seat,
                'bpkb'          => $car->bpkb,
                'spare_key'     => $car->spare_key,
                'manual_book'   => $car->manual_book,
                'service_book'  => $car->service_book, 
                'sale_type'     => $car->sale_type,
                'first_photo'   => $car->mainPhoto && Storage::disk('public')->exists('car_photos/' . $car->mainPhoto->photo_url)
                    ? asset('storage/car_photos/' . $car->mainPhoto->photo_url)
                    : asset('image/NoImage.png'),
            ]);
        $carPhotos = $cars->pluck('first_photo', 'id');

        if ($this->userAsksShowroomLocation($userMessage)) {
            $reply = "Berikut alamat showroom YonoMobilindo:\n\n📍 " . self::SHOWROOM_ADDRESS
                . "\n\n🗺️ Google Maps: " . self::SHOWROOM_MAPS_URL
                . "\n\n📱 WhatsApp: " . self::WHATSAPP_DISPLAY . "\n" . self::WHATSAPP_CTA_PLACEHOLDER;

            return response()->json([
                'reply'     => $reply,
                // 'carPhotos' => $carPhotos,
            ]);
        }

        if ($this->userAsksWhatsAppContact($userMessage)) {
            $reply = '📱 WhatsApp YonoMobilindo: ' . self::WHATSAPP_DISPLAY . "\n\n" . self::WHATSAPP_CTA_PLACEHOLDER;

            return response()->json([
                'reply'     => $reply,
                // 'carPhotos' => $carPhotos,
            ]);
        }

        $systemPrompt = "
            Kamu adalah asisten virtual YonoMobilindo, platform jual beli mobil bekas terpercaya di Indonesia.
            Tugasmu adalah membantu customer untuk:
            1. Menjawab pertanyaan seputar mobil yang tersedia
            2. Memberikan rekomendasi mobil sesuai kebutuhan dan budget customer
            3. Menjelaskan spesifikasi, harga, dan kondisi mobil

            Berikut data mobil yang tersedia saat ini (dalam format JSON):
            " . json_encode($cars, JSON_PRETTY_PRINT) . "

            Aturan menjawab:
            - Jawab dalam Bahasa Indonesia yang ramah dan sopan
            - Jawaban singkat, padat, dan informatif
            - Tampilkan harga dalam format Rupiah
            - Jika mobil tidak ditemukan sesuai kriteria, sarankan alternatif terdekat
            - Pertanyaan tentang lokasi/alamat showroom, dealer, atau kantor YonoMobilindo termasuk topik yang diperbolehkan
            - Jika user bertanya lokasi/alamat showroom, dealer, kantor, atau ingin datang ke tempat (maps, alamat lengkap), jawab dengan alamat dan tautan Google Maps persis berikut tanpa mengubah teks:
              Alamat: " . self::SHOWROOM_ADDRESS . "
              Google Maps: " . self::SHOWROOM_MAPS_URL . "
            - Jangan menjawab pertanyaan di luar topik mobil dan layanan jual beli mobil YonoMobilindo (termasuk lokasi showroom)
            - Jika user bertanya nomor WhatsApp, kontak, CS, atau ingin chat admin, sebut nomor persis: " . self::WHATSAPP_DISPLAY . " lalu baris berikutnya hanya placeholder persis berikut (tanpa URL wa.me di teks, biar jadi tombol di aplikasi): " . self::WHATSAPP_CTA_PLACEHOLDER . "

            PENTING - Jika user meminta daftar/rekomendasi/tampilkan mobil, format menampilkan mobil HARUS persis seperti ini (urutan tidak boleh diubah):
            🚗 [Brand] [Model] [Year]
            💰 [Price]
            ⚙️ [Transmission] | [Fuel Type] | [Mileage] km
            [CAR_ID:id_mobil]

            Contoh yang BENAR:
            🚗 Toyota Avanza 2021
            💰 Rp 100.000.000
            ⚙️ Otomatis | Bensin | 50.000 km
            [CAR_ID:3]

            Ketentuan tambahan:
            - Saat menampilkan mobil, berikan maksimal 3 mobil paling relevan agar mudah dibaca
            - Jangan gunakan format Markdown ![...](...)
            - Jangan ubah urutan format di atas
            - Jangan skip [CAR_ID:X] untuk setiap mobil yang ditampilkan
        ";

        $messages = [['role' => 'system', 'content' => $systemPrompt]];

        foreach ($history as $chat) {
            $messages[] = ['role' => $chat['role'], 'content' => $chat['content']];
        }

        $messages[] = ['role' => 'user', 'content' => $userMessage];

        $response = Http::withHeaders([
            'Authorization' => 'Bearer ' . env('GROQ_API_KEY'),
            'Content-Type'  => 'application/json',
        ])->post('https://api.groq.com/openai/v1/chat/completions', [
            'model'       => 'llama-3.3-70b-versatile',
            'messages'    => $messages,
            'max_tokens'  => 500,
            'temperature' => 0.7,
        ]);

        Log::info('Groq Status: ' . $response->status());
        Log::info('Groq Body: ' . $response->body());

        if ($response->failed()) {
            return response()->json([
                'reply' => 'Error: ' . $response->body()
            ], 500);
        }

        // ✅ return reply jika berhasil
        $reply = $response->json('choices.0.message.content');

        return response()->json([
            'reply' => $reply,
            // 'carPhotos' => $carPhotos,
        ]);
    }

    /**
     * Deteksi permintaan lokasi/alamat showroom agar jawaban selalu konsisten.
     */
    private function userAsksShowroomLocation(string $message): bool
    {
        $m = mb_strtolower($message, 'UTF-8');

        $locationHints = ['lokasi', 'alamat', 'dimana', 'di mana', 'maps', 'map ', 'petunjuk arah', 'google map'];
        $placeHints    = ['showroom', 'dealer', 'kantor', 'toko', 'yonomobilindo', 'yono mobilindo', 'yono'];

        $hasLocation = false;
        foreach ($locationHints as $hint) {
            if (str_contains($m, $hint)) {
                $hasLocation = true;
                break;
            }
        }

        $hasPlace = false;
        foreach ($placeHints as $hint) {
            if (str_contains($m, $hint)) {
                $hasPlace = true;
                break;
            }
        }

        if ($hasLocation && $hasPlace) {
            return true;
        }

        if (str_contains($m, 'alamat kantor') || str_contains($m, 'lokasi kantor')) {
            return true;
        }

        return (bool) preg_match(
            '/\b(showroom|dealer|kantor)\b.*\b(lokasi|alamat|dimana|maps?)\b|\b(lokasi|alamat|dimana|maps?)\b.*\b(showroom|dealer|kantor)\b/u',
            $m
        );
    }

    /**
     * Deteksi pertanyaan kontak / WhatsApp / CS.
     */
    private function userAsksWhatsAppContact(string $message): bool
    {
        $m = mb_strtolower($message, 'UTF-8');

        if (str_contains($m, 'whatsapp') || str_contains($m, 'whats app')) {
            return true;
        }

        if (preg_match('/\bkontak\b/u', $m)) {
            return true;
        }

        if (preg_match('/nomor\s*(hp|telepon|telpon|wa|whatsapp)\b/u', $m)) {
            return true;
        }

        if (preg_match('/\b(hubungi|chat)\b.*\b(wa|whatsapp)\b|\b(wa|whatsapp)\b.*\b(hubungi|chat)\b/u', $m)) {
            return true;
        }

        if (preg_match('/\b(cs|customer\s*service)\b/u', $m)) {
            return true;
        }

        return (bool) preg_match('/\bwa\b/u', $m)
            && (str_contains($m, 'nomor') || str_contains($m, 'admin') || str_contains($m, 'sales'));
    }
}
