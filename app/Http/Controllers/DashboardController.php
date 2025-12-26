<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Verb;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function index(Request $request)
    {
        $user = $request->user();

        // Nombre total de verbes dans la base
        $totalVerbs = Verb::count();

        // Nombre de verbes que l'utilisateur a réussi au moins une fois (is_learned = true)
        // On compte les entrées uniques dans la table daily_verbs pour cet utilisateur
        $learnedVerbsCount = $user->verb()
            ->wherePivot('mastered', true)->count();

        $progressPercent = $totalVerbs > 0 ? ($learnedVerbsCount / $totalVerbs) * 100 : 0;

        return view('dashboard', compact('user', 'learnedVerbsCount', 'totalVerbs', 'progressPercent'));
    }
}
