<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    public function __construct()
    {
        // Make activation link public, other actions require auth
        $this->middleware('auth')->except(['activate']);
        $this->middleware('admin')->except(['show','activate']);
    }

    public function index()
    {
        $users = User::orderBy('id','desc')->paginate(20);
        return view('admin.users.index', compact('users'));
    }

    public function create()
    {
        return view('admin.users.create');
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'name' => ['required','string','max:255'],
            'email' => ['required','email','max:255','unique:users'],
            'password' => ['required','confirmed','min:6'],
            'role' => ['required','in:admin,user'],
        ]);

        $user = User::create([
            'name' => $data['name'],
            'email' => $data['email'],
            'password' => Hash::make($data['password']),
            'role' => $data['role'],
        ]);

        return redirect()->route('admin.users.index')->with('success','User created');
    }

    public function destroy(User $user)
    {
        if (auth()->id() === $user->id) {
            return back()->withErrors(['user' => 'Tidak bisa menghapus akun sendiri']);
        }

        $user->delete();
        return back()->with('success','User dihapus');
    }

    public function show(User $user)
    {
        return view('admin.users.show', compact('user'));
    }

    // admin triggers sending activation email to the user (using approval_token)
    public function sendActivation(User $user)
    {
        // ensure only admin can trigger
        if (auth()->user()->role !== 'admin') abort(403);

        // generate token if missing
        if (!$user->approval_token) {
            $user->approval_token = bin2hex(random_bytes(16));
            $user->save();
        }

        try {
            $admin = auth()->user();
            $m = new \App\Mail\UserActivationEmail($user);
            // Keep From as app default but set Reply-To to the admin for responses
            $m->replyTo($admin->email, $admin->name);
            if (config('queue.default') !== 'sync') {
                \Mail::to($user->email)->queue($m);
            } else {
                \Mail::to($user->email)->send($m);
            }
        } catch (\Throwable $e) {
            \Log::error('Failed to send activation email: '.$e->getMessage());
            return back()->with('error', 'Gagal mengirim email aktivasi (server email tidak tersedia).');
        }

        return back()->with('success', 'Email aktivasi telah dikirim ke pengguna dari alamat admin.');
    }

    // Activate via token (public route)
    public function activate($token)
    {
        $user = User::where('approval_token', $token)->firstOrFail();
        $user->approved = true;
        $user->approved_at = now();
        $user->approval_token = null;
        $user->email_verified_at = now();
        $user->save();

        return view('auth.activation_success', compact('user'));
    }

    // Admin direct approve (without activation link) - marks account active
    public function approve(User $user)
    {
        if (auth()->user()->role !== 'admin') abort(403);
        $user->approved = true;
        $user->approved_at = now();
        $user->approval_token = null;
        $user->email_verified_at = now();
        $user->save();
        return back()->with('success', 'User telah disetujui.');
    }
}
