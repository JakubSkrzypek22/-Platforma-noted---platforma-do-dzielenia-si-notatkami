<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use App\Models\Note;
use App\Models\ChatAnalytics;

/**
 * Controller responsible for handling AI chat requests.
 * Implements a simple RAG (retrieval-augmented generation) flow and logs analytics.
 */
class AiChatController extends Controller
{
    /**
     * POST /api/chat
     * - rate-limited at route level
     * - accepts JSON: { "query": "..." }
     * - returns: { ai_response: string, notes_metadata: [ ... ] }
     */
    public function chat(Request $request)
    {
        $data = $request->validate([
            'query' => 'required|string|max:2000',
        ]);

        $query = trim($data['query']);

        // PERSONALIZATION: include basic user info if authenticated
        $user = Auth::check() ? Auth::user() : null;
        $userContext = '';
        if ($user) {
            $userContext = sprintf("User(id=%d, email=%s, university=%s)", $user->id, $user->email ?? 'n/a', $user->university ?? 'n/a');
        }

        // RAG: split into words, remove short tokens, and perform LIKE searches
        $tokens = preg_split('/[^\p{L}\p{N}_]+/u', mb_strtolower($query));
        $tokens = array_filter(array_map('trim', $tokens), function ($t) { return mb_strlen($t) >= 2; });

        $notesQuery = Note::query();

        if (count($tokens) > 0) {
            foreach ($tokens as $word) {
                $notesQuery->orWhere('title', 'like', "%{$word}%")
                    ->orWhere('description', 'like', "%{$word}%")
                    ->orWhere('university', 'like', "%{$word}%");
            }
        } else {
            // fallback: fuzzy search full query
            $notesQuery->where('title', 'like', "%{$query}%")
                ->orWhere('description', 'like', "%{$query}%");
        }

        // prefer higher viewed notes, limit to 5
        $notes = $notesQuery->orderByDesc('views')->limit(5)->get();

        // ANALYTICS: log query and whether we found matches
        try {
            ChatAnalytics::create([
                'user_id' => $user ? $user->id : null,
                'query' => $query,
                'results_found' => $notes->isNotEmpty() ? 1 : 0,
                'created_at' => now(),
            ]);
        } catch (\Throwable $e) {
            Log::warning('Failed to store chat analytics: ' . $e->getMessage());
        }

        // Prepare notes metadata for client-side rendering
        $notesMetadata = $notes->map(function ($n) {
            return [
                'id' => $n->id,
                'title' => $n->title,
                'price' => $n->price ?? null,
                'rating' => method_exists($n, 'reviews') ? round($n->reviews()->avg('rating') ?? 0, 2) : null,
                'thumbnail' => $n->thumbnail ?? null,
            ];
        })->values();

        // Build prompt for Gemini (system + user + retrieved docs)
        $systemPrompt = "You are Noted AI, an assistant helping users find study notes. Reply concisely. Do NOT output plain clickable links. When recommending notes, use the special tag [note:{id}] exactly — do not use any other formatting for references. Never include raw URLs in Markdown. Keep tone professional and brief.";

        $retrievalContext = "";
        foreach ($notes as $n) {
            $retrievalContext .= sprintf("Note(id=%d) Title: %s; University: %s; Price: %s;\n", $n->id, $n->title, $n->university ?? 'n/a', $n->price ?? 'n/a');
        }

        $userMessage = "User Query: {$query}\nContext: {$userContext}\nRetrieved notes:\n{$retrievalContext}";

        $aiResponseText = null;

        // Call Gemini API if key present. This is a best-effort integration; projects must set GEMINI_API_KEY
        $geminiKey = env('GEMINI_API_KEY');
        if ($geminiKey) {
            try {
                // NOTE: Replace URL with real Gemini endpoint and payload according to provider docs
                $resp = Http::withToken($geminiKey)
                    ->timeout(10)
                    ->post('https://api.openai.com/v1/chat/completions', [
                        'model' => env('GEMINI_MODEL', 'gpt-4o-mini'),
                        'messages' => [
                            ['role' => 'system', 'content' => $systemPrompt],
                            ['role' => 'user', 'content' => $userMessage],
                        ],
                        'max_tokens' => 300,
                        'temperature' => 0.2,
                    ]);

                if ($resp->ok()) {
                    $json = $resp->json();
                    // Try common OpenAI chat completion shape
                    $aiResponseText = $json['choices'][0]['message']['content'] ?? null;
                }
            } catch (\Throwable $e) {
                Log::warning('Gemini/API call failed: ' . $e->getMessage());
            }
        }

        // Fallback: generate a concise response listing recommended notes as [note:id]
        if (!$aiResponseText) {
            if ($notes->isEmpty()) {
                $aiResponseText = "Przykro mi — nie znalazłem notatek pasujących do Twojego zapytania. Spróbuj zmienić słowa kluczowe.";
            } else {
                $ids = $notes->pluck('id')->map(function ($id) { return "[note:{$id}]"; })->join(' ');
                $aiResponseText = "Znalazłem kilka notatek które mogą pomóc: {$ids} — sprawdź je poniżej.";
            }
        }

        return response()->json([
            'ai_response' => $aiResponseText,
            'notes_metadata' => $notesMetadata,
        ]);
    }
}
