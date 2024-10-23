<?php

namespace App\Http\Controllers;

use App\Models\ChatAI;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
class ChatAIController extends Controller
{
    public function index(Request $request)
    {
        $userId = auth()->id();
        // Xóa các bản ghi chat quá 7 ngày
        $sevenDaysAgo = Carbon::now()->subDays(7);
        ChatAI::where('user_id', $userId)
            ->where('created_at', '<', $sevenDaysAgo)
            ->delete();

        // Sử dụng Laravel pagination để phân trang
        $chats = ChatAI::where('user_id', $userId)
            ->orderBy('created_at', 'desc')
            ->paginate(3); // Phân trang với mỗi trang chứa 3 kết quả

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
            $response = Http::timeout(120)->get($apiUrl, ['prompt' => $prompt]);

            if ($response->successful()) {
                $aiResponse = $response->json();
                $responseText = $aiResponse[0]['response']['response'] ?? null;

                if (!$responseText) {
                    return response()->json(['error' => 'Malformed API response'], 500);
                }

                return response()->json(['response' => $responseText]);
            } else {
                return response()->json(['error' => 'Failed to fetch response from AI service'], 500);
            }
        } catch (\Exception $e) {
            return response()->json(['error' => 'Request failed: ' . $e->getMessage()], 500);
        }
    }

    public function store(Request $request)
    {
        $request->validate(['prompt' => 'required|string']);

        $prompt = $request->input('prompt');
        $apiUrl = 'https://solitary-glitter-90d0.nguyenthanhthanhgatay.workers.dev';

        try {
            $response = Http::timeout(120)->get($apiUrl, ['prompt' => $prompt]);

            if ($response->successful()) {
                $aiResponse = $response->json();
                $responseText = $aiResponse[0]['response']['response'] ?? null;

                if (!$responseText) {
                    return response()->json(['error' => 'Malformed API response'], 500);
                }

                // Tạo và lưu lịch sử chat vào database
                $chat = ChatAI::create([
                    'user_id' => auth()->id(),  // Liên kết với người dùng đã xác thực
                    'prompt' => $prompt,
                    'response' => $responseText,
                ]);

                return response()->json(['message' => 'Chat saved successfully', 'chat' => $chat], 201);
            } else {
                return response()->json(['error' => 'Failed to fetch response from AI API'], 500);
            }
        } catch (\Exception $e) {
            return response()->json(['error' => 'Request failed: ' . $e->getMessage()], 500);
        }
    }

    public function destroy()
    {
        $userId = auth()->id();

        try {
            ChatAI::where('user_id', $userId)->delete();
            return response()->json(['message' => 'Chat history deleted successfully'], 200);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Failed to delete chat history'], 500);
        }
    }
}
