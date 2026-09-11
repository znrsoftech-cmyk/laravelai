<?php
namespace App\Http\Controllers;

use App\Ai\Agents\ProductAgent;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Laravel\Ai\Responses\StreamedAgentResponse;

class ChatController extends Controller
{
    public function index()
    {
        return view('chat');
    }

    public function newChat(): \Illuminate\Http\JsonResponse
    {
        $this->resolveUser();
        session()->forget('product_agent_conversation_id');
        session()->put('product_agent_force_new', true);

        return response()->json(['status' => 'ok']);
    }

    public function history(): \Illuminate\Http\JsonResponse
    {
        $user = $this->resolveUser();
        $table = config('ai.conversations.tables.conversations', 'agent_conversations');

        $chats = DB::table($table)
            ->where('user_id', $user->id)
            ->orderByDesc('updated_at')
            ->get(['id', 'title', 'updated_at'])
            ->map(function ($chat) {
                return [
                    'id' => $chat->id,
                    'title' => $chat->title ?: 'Untitled chat',
                    'updated_at' => $chat->updated_at,
                ];
            });

        return response()->json($chats);
    }

    public function selectHistory(Request $request): \Illuminate\Http\JsonResponse
    {
        $request->validate([
            'id' => ['required', 'string'],
        ]);

        $user = $this->resolveUser();
        $table = config('ai.conversations.tables.conversations', 'agent_conversations');

        $exists = DB::table($table)
            ->where('user_id', $user->id)
            ->where('id', $request->input('id'))
            ->exists();

        if (! $exists) {
            abort(404);
        }

        session()->forget('product_agent_force_new');
        session(['product_agent_conversation_id' => $request->input('id')]);

        return response()->json(['status' => 'ok']);
    }

    public function stream(Request $request)
    {
        $request->validate([
            'message' => ['required', 'string', 'max:4000'],
        ]);
        $lastAt = session('last_ai_request_at', 0);
        $now = time();

        if ($now - $lastAt < 3) {
            usleep((3 - ($now - $lastAt)) * 1000000);
        }

        session(['last_ai_request_at' => time()]);

        $user = $this->resolveUser();

        $conversationId = $this->resolveConversation($user);

        $stream = $conversationId
            ? (new ProductAgent)
                ->continue($conversationId, as: $user)
                ->stream($request->message)
            : (new ProductAgent)
                ->forUser($user)
                ->stream($request->message);

        return $stream->then(function ($response) {
            session()->forget('product_agent_force_new');

            if ($response instanceof StreamedAgentResponse && $response->conversationId) {
                session([
                    'product_agent_conversation_id' => $response->conversationId,
                ]);
            }
        });
    }

    protected function resolveUser()
    {
        if (! auth()->check()) {
            $user = User::first();
            auth()->login($user);
        }

        return auth()->user();
    }

    protected function resolveConversation($user): ?string
    {
        if (session('product_agent_force_new')) {
            return null;
        }

        return session('product_agent_conversation_id')
            ?? DB::table('agent_conversations')
                ->where('user_id', $user->id)
                ->latest('updated_at')
                ->value('id');
    }
}