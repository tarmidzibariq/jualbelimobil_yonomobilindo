<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;

class FonnteService
{
    public function sendMessage(string $target, string $message): array
    {
        $response = Http::withHeaders([
            'Authorization' => config('services.fonnte.token'),
        ])->asForm()->post(config('services.fonnte.url'), [
            'target'  => $target,   
            'message' => $message,
        ]);

        return [
            'ok' => $response->successful(),
            'status' => $response->status(),
            'data' => $response->json(),
        ];
    }
}