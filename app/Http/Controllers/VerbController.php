<?php

namespace App\Http\Controllers;

use App\Models\Verb;
use Illuminate\Http\Request;
use Illuminate\View\View;

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
}
