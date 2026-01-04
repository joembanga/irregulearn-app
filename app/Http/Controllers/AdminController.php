<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class AdminController extends Controller
{
    public function dashboard()
    {
        $stats = [
            'users' => \App\Models\User::count(),
            'verbs' => \App\Models\Verb::count(),
            'reports' => \App\Models\Report::count(), // Assuming Report model exists, if not it will error, checking next
            'new_users_today' => \App\Models\User::whereDate('created_at', today())->count(),
        ];

        return view('admin.dashboard', compact('stats'));
    }
}
