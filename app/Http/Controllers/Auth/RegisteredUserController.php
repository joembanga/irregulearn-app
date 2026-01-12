<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\RegisteredUserRequest;
use App\Models\User;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\View\View;

class RegisteredUserController extends Controller
{
    /**
     * Display the registration view.
     */
    public function create(): View
    {
        return view('auth.register');
    }

    /**
     * Handle an incoming registration request.
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    public function store(RegisteredUserRequest $request): RedirectResponse
    {
        $credentials = $request->validated();

        $user = User::create([
            'username' => $credentials['username'],
            'firstname' => $credentials['firstname'],
            'lastname' => $credentials['lastname'],
            'email' => $credentials['email'],
            'password' => Hash::make($credentials['password']),
            'role' => 'user',
            // 'avatar' => $credentials->avatar,
        ]);

        $user->generateDailyVerbs();

        event(new Registered($user));

        Auth::login($user);

        return redirect(route('dashboard', absolute: false));
    }
}
