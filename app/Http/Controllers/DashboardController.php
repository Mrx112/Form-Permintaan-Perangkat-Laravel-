<?php

namespace App\Http\Controllers;

use App\Models\Permintaan;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
        $user = auth()->user();
        if ($user && $user->role === 'admin') {
            $total = Permintaan::count();
            $latest = Permintaan::latest()->limit(5)->get();
        } elseif ($user) {
            $total = Permintaan::where('user_id', $user->id)->count();
            $latest = Permintaan::where('user_id', $user->id)->latest()->limit(5)->get();
        } else {
            $total = 0;
            $latest = collect();
        }

        return view('dashboard', compact('total','latest'));
    }
}
