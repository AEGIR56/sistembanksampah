<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\PasswordResetRequest;

class ForgotPasswordController extends Controller
{
    public function showForgotForm()
    {
        return view('auth.password');
    }

    public function requestReset(Request $request)
    {
        $request->validate([
            'identifier' => 'required|string'
        ]);

        $user = User::where('email', $request->identifier)
            ->orWhere('username', $request->identifier)
            ->orWhere('phone_number', $request->identifier)
            ->first();

        if (!$user) {
            return back()->withErrors(['identifier' => 'Pengguna tidak ditemukan.']);
        }

        PasswordResetRequest::create([
            'user_id' => $user->id,
            'email_or_phone' => $request->identifier,
            'status' => 'pending',
        ]);

        return back()->with('status', 'Permintaan reset password telah dikirim ke admin. Silakan tunggu konfirmasi.');
    }
}

