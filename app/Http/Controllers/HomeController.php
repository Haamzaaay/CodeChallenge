<?php

namespace App\Http\Controllers;

use App\Models\FriendRequest;
use App\Models\User;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        $lazyLoadedUserModel = auth()->user()->load(['sentRequests', 'receivedRequests']);

        $statistics['suggestions'] = User::all();
        $statistics['user_with_relations'] = $lazyLoadedUserModel;

        return view('home', [
            'statistics' => $statistics
        ]);
    }
}
