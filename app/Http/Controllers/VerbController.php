<?php

namespace App\Http\Controllers;

use App\Models\Verb;
use Illuminate\Http\Request;
use Illuminate\View\View;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Facades\Auth;

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

        // Optimize: verify if we need relationships, if not select specific columns
        // avoiding `select *` if the view only shows basic info could be an optimization
        // but simple pagination is usually fine.
        $verbs = $query->paginate(20)->withQueryString();

        return view('verbslist ', compact('verbs', 'filter'));
    }

    /**
     * Export the list of verbs to PDF.
     */
    public function exportPdf()
    {
        $user = Auth::user();

        // Optimized query: Eager load only the pivot data for the current user
        $verbs = Verb::with(['users' => function ($query) use ($user) {
            $query->where('user_id', $user->id);
        }])->orderBy('infinitive')->get();

        $data = [
            'user' => $user,
            'verbs' => $verbs,
            'date' => now()->format('d/m/Y'),
            // 'logo_path' => public_path('images/logo.png'), 
        ];

        // Ensure DOMPDF is installed and aliased or use the Facade
        $pdf = Pdf::loadView('pdf.my-verbs', $data);

        return $pdf->download("IrregularVerbs_list_Irregulearn.pdf");
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
}
