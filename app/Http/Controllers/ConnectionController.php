<?php

namespace App\Http\Controllers;

use App\Enums\FriendRequestStatusEnum;
use App\Models\FriendRequest;
use Illuminate\Http\Request;

class ConnectionController extends Controller
{
    public function index(Request $request)
    {
        $connections = FriendRequest::whereStatus(FriendRequestStatusEnum::ACCEPTED)
            ->whereSenderId(auth()->id())
            ->orWhere('receiver_id', auth()->id())
            ->whereStatus(FriendRequestStatusEnum::ACCEPTED)
            ->with(['sender', 'receiver'])
            ->limit($request->has('limit') ? $request->limit + 1 : 10)
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
