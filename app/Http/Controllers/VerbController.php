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
}
