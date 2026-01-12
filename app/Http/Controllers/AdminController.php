<?php

namespace App\Http\Controllers;

use App\Models\{
    Report,
    User,
    Verb
};
use Illuminate\Http\Request;

class AdminController extends Controller
{
    public function dashboard()
    {
        $stats = [
            'users' => User::count(),
            'verbs' => Verb::count(),
            'reports' => Report::count(),
            'new_users_today' => User::whereDate('created_at', today())->count(),
        ];

        return view('admin.dashboard', compact('stats'));
    }
}
