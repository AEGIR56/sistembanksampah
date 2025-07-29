<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\PasswordResetRequest;
use Illuminate\Support\Facades\Hash;

class AdminPasswordResetController extends Controller
{
    /**
     * Tampilkan semua permintaan reset password yang masih pending.
     */
    public function index()
    {
        $password_requests = PasswordResetRequest::where('status', 'pending')
            ->with('user')
            ->orderByDesc('created_at')
            ->get();

        return view('admin.dashboard', compact('password_requests'));
    }

    /**
     * Reset password user & tandai request completed.
     */
    public function reset(Request $request, $id)
    {
        logger(['reset_request_payload' => $request->all()]);

        $request->validate([
            'new_password' => 'required|string|min:6',
        ]);

        $resetRequest = PasswordResetRequest::with('user')->findOrFail($id);

        if (!$resetRequest->user) {
            return redirect()->back()->withErrors(['error' => 'User tidak ditemukan.']);
        }
        $user = $resetRequest->user;

        if (!$user) {
            return redirect()->back()->withErrors(['error' => 'Pengguna tidak ditemukan.']);
        }

        // Hash password dengan benar
        $hashedPassword = Hash::make($request->new_password);

        $user->update([
            'password' => $hashedPassword,
        ]);

        $resetRequest->update([
            'status' => 'completed',
        ]);

        logger([
            'user_id' => $user->id,
            'new_password_hash' => $hashedPassword
        ]);
        \Log::info('Reset password untuk user:', [
            'user_id' => $user->id,
            'username' => $user->username,
            'password_baru' => $request->new_password,
        ]);

        return redirect()->back()->with('status', 'Password berhasil direset untuk ' . $user->username);
    }
}
