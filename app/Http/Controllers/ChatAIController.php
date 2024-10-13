<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class ChatAIController extends Controller
{
    public function chat(Request $request)
    {
        // Kiểm tra xem request có nhận được prompt không
        $prompt = $request->query('prompt');

        if (!$prompt) {
            return response()->json(['error' => 'No prompt provided'], 400);
        }

        // Gửi yêu cầu tới API Cloudflare Worker
        $apiUrl = 'https://solitary-glitter-90d0.nguyenthanhthanhgatay.workers.dev';

        try {
            // Log để kiểm tra xem request tới API có thành công hay không
            \Log::info('Sending request to AI API with prompt: ' . $prompt);

            $response = Http::timeout(60)->get($apiUrl, ['prompt' => $prompt]);

            if ($response->successful()) {
                \Log::info('API response: ' . $response->body());

                $aiResponse = $response->json();
                $responseText = $aiResponse[0]['response']['response'];

                // Trả về JSON phản hồi
                return response()->json(['response' => $responseText]);
            } else {
                return response()->json(['error' => 'Failed to fetch response from AI service'], 500);
            }
        } catch (\Exception $e) {
            return response()->json(['error' => 'Request timed out: ' . $e->getMessage()], 500);
        }
    }
  //
}
