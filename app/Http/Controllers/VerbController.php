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

        return view('verb', [
            'verb' => $verb,
        ]);
    }

    public function getList(Request $request): View
    {
        $filter = $request->input('level', 'beginner');

        if ($filter === 'all') {
            $query = Verb::orderBy('infinitive', 'asc');
        } else {
            $query = Verb::where('level', $filter)->orderBy('infinitive', 'asc');
        }

        $verbs = $query->paginate(20)->withQueryString();

        return view('verbslist', compact('verbs', 'filter'));
    }

    public function exportPdf()
    {
        $user = Auth::user();
        
        $verbs = Verb::with(['users' => function ($query) use ($user) {
            $query->where('user_id', $user->id);
        }])->orderBy('infinitive')->get();

        $data = [
            'user' => $user,
            'verbs' => $verbs,
            'date' => now()->format('d/m/Y'),
            //'logo_path' => public_path('images/logo.png'), // Assure-toi d'avoir ton logo ici
        ];

        $pdf = Pdf::loadView('pdf.my-verbs', $data);

        return $pdf->download("IrregularVerbs_list_Irregulearn.pdf");
    }
}
