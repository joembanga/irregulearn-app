<?php

namespace App\Http\Controllers;

use App\Models\VerbExample;
use Illuminate\Http\Request;
use Illuminate\View\View;

class SocialController extends Controller
{
    /**
     * Display the user's friends list.
     */
    public function grambuds(Request $request): View
    {
        $user = $request->user();
        $friends = $user->friends()->paginate(12);

        return view('grambuds', [
            'friends' => $friends,
        ]);
    }

    /**
     * Display the community's submitted verb examples.
     */
    public function sentences(Request $request): View
    {
        $userFriendsIds = $request->user()->friends()->pluck('id')->toArray();
        $examples = VerbExample::where('is_hidden', false)
            ->with(['verb', 'user'])
            ->orderByDesc('created_at')
            ->paginate(15);

        return view('sentences', [
            'examples' => $examples,
            'friendsIds' => $userFriendsIds
        ]);
    }

    /**
     * Display the user's weekly mastery reports.
     */
    public function weeklyReports(Request $request): View
    {
        $reports = $request->user()->weeklyReports()->paginate(10);

        return view('weekly-reports', [
            'reports' => $reports,
        ]);
    }
}
