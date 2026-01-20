<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;

class LearnController extends Controller
{
    public function index(Request $request)
    {
        $user = $request->user();

        $cacheKey = "user_categories_progress_{$user->id}";

        $categories = Cache::remember($cacheKey, now()->addMinutes(30), function () use ($user) {
            return Category::orderBy('order')
                ->get()
                ->map(function ($category) use ($user) {
                    $totalVerbs = $category->verbs()->count();
                    $masteredCount = $user->masteredVerbs()
                        ->whereHas('categories', function ($q) use ($category) {
                            $q->where('categories.id', $category->id);
                        })->count();

                    $category->progress = ($totalVerbs > 0) ? round(($masteredCount / $totalVerbs) * 100) : 0;
                    $category->is_locked = ! $user->canAccessCategory($category);

                    return $category;
                });
        });

        return view('learn', compact('user', 'categories'));
    }

    public function startSession(Request $request)
    {
        $availableModes = ['category', 'daily', 'favorites', 'revision', 'timed'];
        $mode = $request->input('mode') ?? 'daily';
        if ($request->input('mode') === null || ! in_array($mode, $availableModes)) {
            $mode = 'daily';
        }
        if ($mode === 'category') {
            $category = Category::where('slug', $request->input('name'))->first();
            if (! $category || ! $request->user()->canAccessCategory($category)) {
                return redirect()->route('learn.index');
            }

            return view('learn-session', ['slug' => $category->slug, 'mode' => 'category']);
        }

        return view('learn-session', ['slug' => null, 'mode' => $mode]);
    }

    public function custom(Request $request)
    {
        $user = $request->user();
        
        // Get only accessible categories with their verbs
        $categories = Category::with('verbs')
            ->orderBy('order')
            ->get()
            ->filter(function ($category) use ($user) {
                return $user->canAccessCategory($category);
            });
        
        return view('learn-custom', compact('categories'));
    }
}
