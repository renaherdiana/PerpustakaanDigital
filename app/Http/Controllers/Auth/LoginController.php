<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Models\Anggota;
use App\Models\User;

class LoginController extends Controller
{

    // ===============================
    // TAMPILKAN FORM LOGIN
    // ===============================
    public function showLoginForm()
    {
        return view('auth.login');
    }


    // ===============================
    // PROSES LOGIN
    // ===============================
    public function login(Request $request)
    {
        $request->validate([
            'email' => 'required',
            'password' => 'required',
        ]);

        $login = $request->email;
        $password = $request->password;


        /*
        ===============================
        LOGIN PETUGAS / SUPERADMIN (cek duluan)
        ===============================
        */
        if (Auth::attempt(['email' => $login, 'password' => $password])) {

            $request->session()->regenerate();
            $user = Auth::user();

            if ($user->status !== 'aktif') {
                Auth::logout();
                return back()->with('error', 'Akun belum aktif');
            }

            if ($user->role == 'superadmin') {
                return redirect('/superadmin/dashboard');
            }

            if ($user->role == 'petugas') {
                return redirect('/admin/dashboard');
            }

            Auth::logout();
            return back()->with('error', 'Role tidak dikenali');
        }

        /*
        ===============================
        LOGIN ANGGOTA (NIS atau email)
        ===============================
        */
        $anggota = Anggota::where('nis', $login)
            ->orWhere('email', $login)
            ->first();

        if ($anggota && Hash::check($password, $anggota->password)) {

            if ($anggota->status !== 'aktif') {
                return back()->with('error', 'Akun kamu tidak aktif. Hubungi petugas perpustakaan.');
            }

            session([
                'login_type'   => 'anggota',
                'anggota_id'   => $anggota->id,
                'anggota_nama' => $anggota->nama,
            ]);
            return redirect()->route('home');
        }

        return back()->with('error', 'Email / NIS atau password salah');
    }



    // ===============================
    // LOGOUT
    // ===============================
    public function logout(Request $request)
    {

        Auth::logout();

        session()->forget([
            'login_type',
            'anggota_id',
            'anggota_nama'
        ]);

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('login');
    }
}
