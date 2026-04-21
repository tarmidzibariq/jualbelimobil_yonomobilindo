<?php

namespace App\Helpers;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class WhatsAppHelper
{
    public static function normalizePhone(?string $phone): ?string
    {
        if (!$phone) {
            return null;
        }

        $digits = preg_replace('/\D+/', '', $phone);

        if (!$digits) {
            return null;
        }

        if (str_starts_with($digits, '0')) {
            return '62' . substr($digits, 1);
        }

        if (str_starts_with($digits, '8')) {
            return '62' . $digits;
        }

        if (str_starts_with($digits, '62')) {
            return $digits;
        }

        return $digits;
    }

    public static function send(?string $phone, string $message, array $meta = []): bool
    {
        $target = self::normalizePhone($phone);
        $token = config('services.fonnte.token');
        $url = config('services.fonnte.url', 'https://api.fonnte.com/send');

        if (!$target || !$token) {
            Log::warning('WhatsApp notification skipped because target or token is missing.', [
                'target' => $target,
                'has_token' => !empty($token),
                'meta' => $meta,
            ]);

            return false;
        }

        try {
            $response = Http::withHeaders([
                'Authorization' => $token,
            ])->asForm()->post($url, [
                'target' => $target,
                'message' => $message,
            ]);

            if (!$response->successful()) {
                Log::error('WhatsApp notification failed.', [
                    'status' => $response->status(),
                    'body' => $response->body(),
                    'meta' => $meta,
                ]);

                return false;
            }

            return true;
        } catch (\Throwable $th) {
            Log::error('WhatsApp notification exception.', [
                'error' => $th->getMessage(),
                'meta' => $meta,
            ]);

            return false;
        }
    }
}
