<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    public function __construct()
    {
        $this->middleware('guest')->except('logout');
        $this->middleware('auth')->only('logout');
    }

    public function showLogin()
    {
        return view('auth.login');
    }

    public function login(Request $request)
    {
        $data = $request->validate([
            'username' => ['required','string'],
            'password' => ['required'],
        ]);

        $login = $data['username'];

        // allow login by email or username
        $field = filter_var($login, FILTER_VALIDATE_EMAIL) ? 'email' : 'name';

        $user = User::where($field, $login)->first();
        if ($user && !$user->approved) {
            return back()->withErrors(['username' => 'Akun Anda belum diaktifkan oleh admin. Silakan tunggu konfirmasi.'])->withInput();
        }

        if (Auth::attempt([$field => $login, 'password' => $data['password']], $request->boolean('remember'))) {
            $request->session()->regenerate();
            // Redirect to dashboard after login (preserve intended destination if present)
            return redirect()->intended(route('dashboard'));
        }

        return back()->withErrors(['username' => 'Login gagal'])->withInput();
    }

    public function showRegister()
    {
        return view('auth.register');
    }

    public function register(Request $request)
    {
        $data = $request->validate([
            'name' => ['required','string','max:255'],
            'email' => ['required','email','max:255','unique:users'],
            'password' => ['required','confirmed','min:6'],
        ]);

        // create user but mark as not approved. Admin must approve first.
        $token = bin2hex(random_bytes(16));

        $user = User::create([
            'name' => $data['name'],
            'email' => $data['email'],
            'password' => Hash::make($data['password']),
            'role' => 'user',
            'approved' => false,
            'approval_token' => $token,
        ]);

        // Notify admins that a new user needs approval
        $admins = User::where('role', 'admin')->get();
        foreach ($admins as $admin) {
            try {
                $m = new \App\Mail\AdminUserApprovalRequest($user);
                // If queue driver is configured to something other than 'sync', queue the mail
                if (config('queue.default') !== 'sync') {
                    \Mail::to($admin->email)->queue($m);
                } else {
                    \Mail::to($admin->email)->send($m);
                }
            } catch (\Throwable $e) {
                \Log::error('Failed to send admin approval email: '.$e->getMessage());
                // continue without failing registration
            }
        }

        return view('auth.register_pending');
    }

    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect('/');
    }
}
