<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Verb;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PracticeController extends Controller
{
    public function exercises() {
        $user = Auth::user();

        // Groupes de verbes
        $stats = [
            'beginner' => Verb::where('level', 'beginner')->count(),
            'intermediate' => Verb::where('level', 'intermediate')->count(),
            'expert' => Verb::where('level', 'expert')->count(),
        ];

        // Top 3 pour la motivation
        $topThree = User::orderBy('xp_total', 'desc')->take(3)->get();

        return view('practice', compact('stats', 'topThree'));
    }
}
