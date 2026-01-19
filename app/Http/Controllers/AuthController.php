<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
  public function showLogin()
  {
    return view('auth.login');
  }

  public function login(Request $request)
  {
    $data = $request->validate([
      'username' => ['required','string'],
      'password' => ['required','string'],
    ]);

    if (Auth::attempt(['username'=>$data['username'], 'password'=>$data['password']], true)) {
      $request->session()->regenerate();
      return match ($request->user()->role) {
        'admin' => redirect()->route('admin.dashboard'),
        'pm'    => redirect()->route('pm.form'),
        default => redirect()->route('wa.form'),
      };
    }

    return back()->withErrors(['username'=>'Username atau password salah'])->onlyInput('username');
  }

  public function logout(Request $request)
  {
    Auth::logout();
    $request->session()->invalidate();
    $request->session()->regenerateToken();
    return redirect()->route('login');
  }
}
