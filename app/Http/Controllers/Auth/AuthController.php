<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Session;

class AuthController extends Controller
{
    public function showLogin()
    {
        return view('auth.login');
    }

    public function showRegister()
    {
        $roles = DB::table('roles')->get();
        return view('auth.register', compact('roles'));
    }

    public function login(Request $request)
    {
        $request->validate([
            'username' => 'required',
            'password' => 'required',
        ]);

        $user = DB::table('users')
            ->where('username', $request->username)
            ->where('is_active', 1)
            ->first();

        if (!$user || !Hash::check($request->password, $user->password)) {
            return back()->withErrors([
                'login_error' => 'Username atau Password salah'
            ]);
        }

        // SIMPAN SESSION
        Session::put('user', [
            'id'        => $user->id,
            'name'      => $user->name,
            'role_id'   => $user->role_id,
            'doctor_id' => $user->doctor_id ?? null,
        ]);

        // ==============================
        // REDIRECT BERDASARKAN ROLE (FIX WAJIB - UPGRADE VERSION)
        // ==============================

        $redirectUrl = '/dashboard'; // default = Admin

        if ($user->role_id == 2) {
            $redirectUrl = '/dashboard-doctor';
        }

        if ($user->role_id == 3) {
            $redirectUrl = '/dashboard-nurse';
        }

        // fallback safety kalau role aneh / null
        if (!in_array($user->role_id, [1, 2, 3])) {
            return redirect('/login');
        }

        return redirect($redirectUrl)
                ->with('login_success', true)
                ->with('login_name', $user->name);
        }

    public function register(Request $request)
    {
        $request->validate([
            'name'     => 'required|string|max:150',
            'email'    => 'nullable|email|unique:users,email',
            'username' => 'required|string|max:100|unique:users,username',
            'password' => 'required|min:6',
            'role_id'  => 'required|exists:roles,id',
        ]);

        DB::table('users')->insert([
            'role_id'    => $request->role_id,
            'name'       => $request->name,
            'email'      => $request->email,
            'username'   => $request->username,
            'password'   => Hash::make($request->password),
            'is_active'  => 1,
            'created_at' => now(),
        ]);

        return redirect('/login')
            ->with('register_success', true)
            ->with('register_name', $request->name);
    }

    public function logout()
    {
        $name = session('user.name');

        Session::flush();

        return redirect('/login')
            ->with('logout_success', true)
            ->with('logout_name', $name);
    }
}
