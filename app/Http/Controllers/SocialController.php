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
     * Display the user's submitted verb examples.
     */
    public function sentences(Request $request): View
    {
        $user = $request->user();
        $examples = VerbExample::where('user_id', $user->id)
            ->with('verb')
            ->orderByDesc('created_at')
            ->paginate(15);

        return view('sentences', [
            'examples' => $examples,
        ]);
    }
}
