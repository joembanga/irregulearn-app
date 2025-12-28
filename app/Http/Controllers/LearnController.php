<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Verb;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class LearnController extends Controller
{
    public function index(Request $request)
    {
        $user = $request->user();

        // Eager load verbs count to prevent N+1
        $categories = Category::withCount('verbs')->orderBy('order')->get()->map(function ($category) use ($user) {
            $totalVerbs = $category->verbs_count;

            $masteredCount = $user->masteredVerbs()
                ->whereHas('categories', function ($q) use ($category) {
                    $q->where('categories.id', $category->id);
                })->count();

            $category->progress = ($totalVerbs > 0) ? round(($masteredCount / $totalVerbs) * 100) : 0;
            $category->is_locked = !$user->canAccessCategory($category);
            return $category;
        });

        return view('learn', compact('categories'));
    }

    public function show($slug) {
        return view('category-learn', ['slug' => $slug]);
    }
}
