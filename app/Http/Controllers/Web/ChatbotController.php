<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Models\Car;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class ChatbotController extends Controller
{
    public function chat(Request $request)
    {
        $request->validate(['message' => 'required|string']);

        $userMessage = $request->input('message');
        $history     = $request->input('history', []);

        $cars = Car::where('status', 'available')
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
            ]);

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
            - Jangan menjawab pertanyaan di luar topik mobil

            PENTING - Format menampilkan mobil:
            Setiap kali menampilkan mobil, WAJIB tulis ID mobil dengan format: [CAR_ID:angka_id]
            
            Contoh format jawaban yang BENAR:
            🚗 Toyota Avanza 2021
            💰 Rp 100.000.000
            ⚙️ Otomatis | Bensin | 50.000 km
            [CAR_ID:3]

            Gunakan id dari field 'id' pada data mobil.
            Jangan skip format [CAR_ID:X], selalu sertakan di setiap mobil yang ditampilkan.
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

        return response()->json(['reply' => $reply]);
    }
}
