<?php

namespace App\Http\Controllers;

use App\Models\ChatAI;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class ChatAIController extends Controller
{
    public function index(){
        // Fetch all chat records
        $chats = ChatAI::all();

        // Return the view with chat data
        return view('chatAI', compact('chats'));
    }

    public function chat(Request $request)
    {
        $prompt = $request->query('prompt');

        if (!$prompt) {
            return response()->json(['error' => 'No prompt provided'], 400);
        }

        $apiUrl = 'https://solitary-glitter-90d0.nguyenthanhthanhgatay.workers.dev';

        try {
            Log::info('Sending request to AI API with prompt: ' . $prompt);
            $response = Http::timeout(60)->get($apiUrl, ['prompt' => $prompt]);

            if ($response->successful()) {
                $aiResponse = $response->json();
                $responseText = $aiResponse[0]['response']['response'] ?? null;

                if (!$responseText) {
                    Log::error('Malformed API response');
                    return response()->json(['error' => 'Malformed API response'], 500);
                }

                return response()->json(['response' => $responseText]);
            } else {
                Log::error('Failed to fetch response from AI service');
                return response()->json(['error' => 'Failed to fetch response from AI service'], 500);
            }
        } catch (\Exception $e) {
            Log::error('Exception in chat request: ' . $e->getMessage());
            return response()->json(['error' => 'Request failed: ' . $e->getMessage()], 500);
        }
    }

    public function store(Request $request)
    {
        $request->validate(['prompt' => 'required|string']);

        $prompt = $request->input('prompt');
        $apiUrl = 'https://solitary-glitter-90d0.nguyenthanhthanhgatay.workers.dev';

        try {
            Log::info('Sending request to AI API with prompt: ' . $prompt);
            $response = Http::timeout(60)->get($apiUrl, ['prompt' => $prompt]);

            if ($response->successful()) {
                $aiResponse = $response->json();
                $responseText = $aiResponse[0]['response']['response'] ?? null;

                if (!$responseText) {
                    Log::error('Malformed API response');
                    return response()->json(['error' => 'Malformed API response'], 500);
                }

                $chat = ChatAI::create([
                    'prompt' => $prompt,
                    'response' => $responseText,
                ]);

                Log::info('Chat saved successfully', ['chat' => $chat]);
                return response()->json(['message' => 'Chat saved successfully', 'chat' => $chat], 201);
            } else {
                Log::error('Failed to fetch response from AI API');
                return response()->json(['error' => 'Failed to fetch response from AI API'], 500);
            }
        } catch (\Exception $e) {
            Log::error('Exception in store request: ' . $e->getMessage());
            return response()->json(['error' => 'Request failed: ' . $e->getMessage()], 500);
        }
    }
}