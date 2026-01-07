<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Http\Request;

class LearnController extends Controller
{
    public function index(Request $request)
    {
        $user = $request->user();

        // Optimized query: eager load verb counts and use subquery for mastered counts
        $categories = Category::withCount('verbs')
            ->orderBy('order')
            ->get()
            ->map(function ($category) use ($user) {
                // Efficiently get mastered count for this specific category
                // We could optimize this further with a single massive query if needed,
                // but this removes the loop over the relationship collection.
                $masteredCount = $user->masteredVerbs()
                    ->whereHas('categories', function ($q) use ($category) {
                        $q->where('categories.id', $category->id);
                    })->count();

                $totalVerbs = $category->verbs_count;
                $category->progress = ($totalVerbs > 0) ? round(($masteredCount / $totalVerbs) * 100) : 0;
                $category->is_locked = false;

                return $category;
            });

        return view('learn', compact('categories'));
    }

    public function show($slug)
    {
        return view('learn-session', ['slug' => $slug, 'mode' => 'category']);
    }

    public function daily()
    {
        return view('learn-session', ['slug' => null, 'mode' => 'daily']);
    }

    public function favorites()
    {
        return view('learn-session', ['slug' => null, 'mode' => 'favorites']);
    }

    public function knowVerbs()
    {
        return view('learn-session', ['slug' => null, 'mode' => 'knowVerbs']);
    }
}
