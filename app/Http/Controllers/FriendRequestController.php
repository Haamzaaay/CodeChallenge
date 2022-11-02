<?php

namespace App\Http\Controllers;

use App\Enums\FriendRequestStatusEnum;
use App\Models\FriendRequest;

class FriendRequestController extends Controller
{
    public function getRequests()
    {
        $requestsSent = FriendRequest::whereSenderId(auth()->id())
            ->whereStatus(FriendRequestStatusEnum::PENDING)->with('receiver')->get();

        $requestsReceived = FriendRequest::whereReceiverId(auth()->id())
            ->whereStatus(FriendRequestStatusEnum::PENDING)->with('sender')->get();

        return response()->json([
            [
                'total' => $requestsSent->count(),
                'data' => view('components.request', ['requests' => $requestsSent, 'mode' => 'sent'])->render()

            ],
            [
                'total' => $requestsReceived->count(),
                'data' => view('components.request', ['requests' => $requestsReceived, 'mode' => 'received'])->render()

            ],
        ]);
    }

    public function withdrawRequest(FriendRequest $friendRequest)
    {
        $friendRequest->delete();

        return response()->noContent();
    }

    public function acceptRequest(FriendRequest $friendRequest)
    {
        $friendRequest->update(['status' => FriendRequestStatusEnum::ACCEPTED]);

        return response()->noContent();
    }

    public function storeRequest($suggestionId)
    {
        auth()->user()->sentRequests()->firstOrCreate(['receiver_id' => $suggestionId]);

        return response()->noContent();
    }
}
