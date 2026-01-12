<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use Laravel\Socialite\Facades\Socialite;

class GoogleController extends Controller
{
    /**
     * Redirect the user to Google's OAuth page.
     */
    public function redirect(): RedirectResponse
    {
        // Store the referrer to redirect back in case of error
        session(['google_auth_origin' => url()->previous()]);

        return Socialite::driver('google')->redirect();
    }

    /**
     * Handle the callback from Google.
     */
    public function callback(): RedirectResponse
    {
        try {
            $googleUser = Socialite::driver('google')->user();
        } catch (\Exception $e) {
            $origin = session('google_auth_origin', route('login'));

            return redirect($origin)->with('error', 'Erreur de connexion avec Google. Veuillez réessayer.');
        }

        // Find existing user by google_id or email
        $user = User::where('google_id', $googleUser->getId())
            ->orWhere('email', $googleUser->getEmail())
            ->first();

        if ($user) {
            // Update google_id if user exists but logged in via email before
            if (! $user->google_id) {
                $user->update(['google_id' => $googleUser->getId()]);
            }

            // Mark email as verified since Google has verified it
            if (! $user->email_verified_at) {
                $user->email_verified_at = now();
                $user->save();
            }
        } else {
            // Create new user
            $nameParts = explode(' ', $googleUser->getName(), 2);
            $firstname = $nameParts[0] ?? '';
            $lastname = $nameParts[1] ?? '';

            // Generate unique username
            $baseUsername = Str::slug(strtolower($firstname), '');
            $username = $baseUsername;
            $counter = 1;
            while (User::where('username', $username)->exists()) {
                $username = $baseUsername.$counter;
                $counter++;
            }

            $user = User::create([
                'google_id' => $googleUser->getId(),
                'email' => $googleUser->getEmail(),
                'firstname' => $firstname,
                'lastname' => $lastname,
                'username' => $username,
                'password' => bcrypt(Str::random(24)), // Random password since they'll use Google
                'email_verified_at' => now(), // Verified by Google
            ]);
        }

        Auth::login($user, true);

        return redirect(route('dashboard', absolute: false));
    }
}
