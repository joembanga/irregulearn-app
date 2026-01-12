<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Http\Request;

class LearnController extends Controller
{
    public function index(Request $request)
    {
        $user = $request->user();

        $cacheKey = "user_categories_progress_{$user->id}";
        
        $categories = \Illuminate\Support\Facades\Cache::remember($cacheKey, now()->addMinutes(30), function() use ($user) {
            return Category::withCount('verbs')
                ->orderBy('order')
                ->get()
                ->map(function ($category) use ($user) {
                    $masteredCount = $user->masteredVerbs()
                        ->whereHas('categories', function ($q) use ($category) {
                            $q->where('categories.id', $category->id);
                        })->count();

                    $totalVerbs = $category->verbs_count;
                    $category->progress = ($totalVerbs > 0) ? round(($masteredCount / $totalVerbs) * 100) : 0;
                    $category->is_locked = false; // Add logic if needed, but keeping simple for now

                    return $category;
                });
        });

        return view('learn', compact('categories'));
    }

    public function startSession(Request $request)
    {
        $availableModes = ['category', 'daily', 'favorites', 'knowVerbs'];
        $mode = $request->input('mode') ?? 'daily';
        if ($request->input('mode') === null || !in_array($mode, $availableModes)) {
            $mode = 'daily';
        }
        if ($mode === 'category') {
            $availableCategories = Category::pluck('slug')->toArray();
            if (!in_array($request->input('name'), $availableCategories)) {
                return redirect()->route('learn.index');
            }
            return view('learn-session', ['slug' => $request->input('name'), 'mode' => 'category']);
        }
        return view('learn-session', ['slug' => null, 'mode' => $mode]);
    }
}
