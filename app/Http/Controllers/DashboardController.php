<?php

namespace App\Http\Controllers;

use App\Models\Verb;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index(Request $request)
    {
        $user = $request->user();

        // Total number of verbs in the database
        $totalVerbs = Verb::count();

        // Number of verbs mastered by the user (mastered = true)
        $learnedVerbsCount = $user->learnedVerbs()->count();

        $progressPercent = $totalVerbs > 0 ? ($learnedVerbsCount / $totalVerbs) * 100 : 0;

        $userLevel = $user->level_name;

        return view('dashboard', compact('user', 'learnedVerbsCount', 'totalVerbs', 'progressPercent', 'userLevel'));
    }
}
