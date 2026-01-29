<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProfileUpdateRequest;
use App\Models\Badge;
use App\Models\User;
use App\Models\VerbExample;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Illuminate\View\View;

class ProfileController extends Controller
{
    /**
     * Display the user's profile form.
     */
    public function edit(Request $request): View
    {
        return view('profile.edit', [
            'user' => $request->user(),
        ]);
    }

    /**
     * Update the user's profile information.
     */
    public function update(ProfileUpdateRequest $request): RedirectResponse
    {
        $request->user()->fill($request->validated());

        if ($request->user()->isDirty('email')) {
            $request->user()->email_verified_at = null;
        }

        $request->user()->save();

        return Redirect::route('profile.edit')->with('status', 'profile-updated');
    }

    /**
     * Delete the user's account.
     */
    public function destroy(Request $request): RedirectResponse
    {
        $request->validateWithBag('userDeletion', [
            'password' => ['required', 'current_password'],
        ]);

        $user = $request->user();

        Auth::logout();

        $user->delete();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return Redirect::to('/');
    }

    public function showPublicProfile($username): View
    {
        $user = User::where('username', $username)->firstOrFail();
        $examples = VerbExample::where(['user_id' => $user->id, 'is_hidden' => false])
            ->with('verb')
            ->orderByDesc('created_at')
            ->paginate(15);

        $allBadges = Badge::orderBy('requirement_value')->get();
        $userBadgeIds = $user->badges->pluck('id')->toArray();

        return view('profile.public', [
            'user' => $user,
            'examples' => $examples,
            'allBadges' => $allBadges,
            'userBadgeIds' => $userBadgeIds
        ]);
    }

    public function userTz(Request $request): void
    {
        $validated = $request->validate([
            'timezone' => 'required|string|max:255',
        ]);
        $request->user()->update([
            'timezone' => $validated['timezone'],
        ]);
    }
}
