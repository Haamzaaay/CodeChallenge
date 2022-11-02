<?php

namespace App\Http\Controllers;

use App\Enums\FriendRequestStatusEnum;
use App\Models\FriendRequest;

class ConnectionController extends Controller
{
    public function index()
    {
        $connections = FriendRequest::whereStatus(FriendRequestStatusEnum::ACCEPTED)
            ->whereSenderId(auth()->id())
            ->orWhere('receiver_id', auth()->id())
            ->whereStatus(FriendRequestStatusEnum::ACCEPTED)
            ->with(['sender', 'receiver'])
            ->get();

        return response()->json([
            'total' => $connections->count(),
            'data' => view('components.connection', ['connections' => $connections])->render()
        ], 200);
    }

    public function destroy(FriendRequest $connection)
    {
        $connection->delete();

        return response()->noContent();
    }
}
