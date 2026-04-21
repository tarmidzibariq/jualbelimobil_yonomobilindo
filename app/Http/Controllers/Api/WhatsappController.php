<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Services\FonnteService;
use Illuminate\Http\Request;

class WhatsappController extends Controller
{
    public function send(Request $request, FonnteService $fonnte) {
        $validate = $request->validate([
            'target' => 'required|string',
            'message' => 'required|string',
        ]);
        
        $result = $fonnte->sendMessage($validate['target'], $validate['message']);

        if(!$result['ok']) {
            return response()->json([
                'message' => 'Failed to send message',
                'fonnte' => $result['data'],
            ], 500);
        }

        return response()->json([
            'message' => 'Pesan berhasil dikirim',
            'fonnte' => $result['data'],
        ]);
    }
}
