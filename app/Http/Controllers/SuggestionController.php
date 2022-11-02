<?php

namespace App\Http\Controllers;

use App\Models\FriendRequest;
use App\Models\User;
use Illuminate\Http\Request;

class SuggestionController extends Controller
{
    public function index()
    {
        [$requestsSent, $requestesReceived] =
            [
                FriendRequest::where('sender_id', auth()->id())->pluck('receiver_id')->toArray(),
                FriendRequest::where('receiver_id', auth()->id())->pluck('sender_id')->toArray()
            ];

        $suggestions = User::whereNotIn('id', array_merge($requestsSent, $requestesReceived))
            ->get()->except(auth()->id());

        return response()->json([
            'total' => $suggestions->count(),
            'data' => view('components.suggestion', ['suggestions' => $suggestions])->render()
        ], 200);
    }
}
