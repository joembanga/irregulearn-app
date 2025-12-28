<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class LeaderboardController extends Controller
{
    public function load (Request $request) {
        $user = Auth::user();
        $filter = $request->input('filter', 'global');
        $period = $request->input('period', 'weekly');

        $sortColumn = ($period === 'weekly') ? 'xp_weekly' : 'xp_total';

        $query = User::orderBy($sortColumn, 'desc');

        if ($filter === 'friends') {
            $friendships = \App\Models\Friendship::where('status', 'accepted')
                ->where(function ($q) use ($user) {
                    $q->where('sender_id', $user->id)->orWhere('recipient_id', $user->id);
                })->get();

            $friendIds = $friendships->map(function ($row) use ($user) {
                return $row->sender_id === $user->id ? $row->recipient_id : $row->sender_id;
            })->unique()->toArray();

            // Add current user
            $friendIds[] = $user->id;

            $query->whereIn('id', $friendIds);
        }

        $users = $query->paginate(20)->withQueryString();

        return view('leaderboard', compact('users', 'filter', 'period'));
    }
}
