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

        $userLevel = null;
        if ($user->xp_total >= 0 && $user->xp_total < 5000) {
            $userLevel = "Apprenti";
        } elseif ($user->xp_total >= 5000 && $user->xp_total < 10000) {
            $userLevel = "Niveau 2";
        } elseif ($user->xp_total >= 10000 && $user->xp_total < 30000) {
            $userLevel = "Niveau 3";
        } elseif ($user->xp_total >= 30000 && $user->xp_total < 50000) {
            $userLevel = "Niveau 4";
        } elseif ($user->xp_total >= 50000) {
            $userLevel = "God";
        }

        return view('dashboard', compact('user', 'learnedVerbsCount', 'totalVerbs', 'progressPercent', 'userLevel'));
    }
}
