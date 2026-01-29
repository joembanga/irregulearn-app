<?php

namespace App\Http\Controllers;

use App\Jobs\ProcessPdfExport;
use App\Models\Verb;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;
use Illuminate\View\View;

class VerbController extends Controller
{
    public function getVerb($slug): View
    {
        $verb = Verb::where('slug', $slug)->firstOrFail();

        $previous = Verb::where('infinitive', '<', $verb->infinitive)
            ->orderBy('infinitive', 'desc')
            ->first();

        // Get the next verb (alphabetical)
        $next = Verb::where('infinitive', '>', $verb->infinitive)
            ->orderBy('infinitive', 'asc')
            ->first();

        return view('verb', compact('verb', 'previous', 'next'));
    }

    public function getList(Request $request): View
    {
        $filter = $request->input('level', 'beginner');

        $query = Verb::query()->orderBy('infinitive', 'asc');

        if ($filter !== 'all') {
            $query->where('level', $filter);
        }

        $page = $request->input('page', 1);
        $cacheKey = "verbs_list_{$filter}_page_{$page}";

        $verbs = Cache::remember($cacheKey, now()->addHours(1), function () use ($query) {
            return $query->paginate(24);
        });

        $verbs->withQueryString();

        return view('verbslist', compact('verbs', 'filter'));
    }

    /**
     * Export the list of verbs to PDF.
     */
    public function exportPdf()
    {
        $user = Auth::user();

        // Execute PDF export synchronously
        (new ProcessPdfExport($user))->handle();

        return back()->with('success', 'Le PDF de tes verbes a été généré et envoyé par email !');
    }

    public function listFavs()
    {
        /**
         * @var \App\Models\User $user
         */
        $user = Auth::user();
        $verbs = $user->favorites; // Get all favorite verbs of the user

        return view('favorites', compact('verbs'));
    }

    public function today()
    {
        if (Auth::check()) {
            $user = Auth::user();
            $user->generateDailyVerbs();
            $dailyVerbs = $user->dailyVerbs;
        } else {
            // Guest logic: seeded random verbs based on date
            // Seed with today's timestamp (days since epoch) to keep it consistent for 24h
            $seed = floor(time() / 86400);
            $dailyVerbs = Verb::inRandomOrder($seed)->limit(5)->get();
            $user = null;
        }

        return view('daily-verbs', compact('dailyVerbs', 'user'));
    }
}
