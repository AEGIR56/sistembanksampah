<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;
use App\Models\User;
use App\Helpers\LogHelper;

class AuthController extends Controller
{
    public function login(Request $request)
    {
        Log::info('Login Request:', $request->all());

        $validator = Validator::make($request->all(), [
            'username' => 'required|string',
            'password' => 'required|string|min:6',
        ]);

        if ($validator->fails()) {
            Log::error('Validation Failed:', $validator->errors()->toArray());
            return back()->withErrors($validator)->withInput();
        }

        try {
            $user = User::where('username', $request->username)
                        ->orWhere('email', $request->username)
                        ->first();

            if (!$user) {
                Log::error('User not found', ['identifier' => $request->username]);
                return back()->with('error', 'Invalid credentials.')->withInput();
            }

            if (!Hash::check($request->password, $user->password)) {
                logger()->error('Password mismatch', [
                    'identifier' => $request->username,
                    'hashed_in_db' => $user->password,
                    'entered' => $request->password,
                    'check' => Hash::check($request->password, $user->password),
                ]);
                return back()->with('error', 'Invalid credentials.')->withInput();
            }

            Auth::login($user);
            Log::info('User logged in successfully', ['user_id' => $user->id]);

            LogHelper::record('Login', 'User berhasil login.');

            switch ($user->role) {
                case 'admin':
                    return redirect()->route('admin.dashboard')->with('success', 'Welcome back, Admin!');
                case 'staff':
                    return redirect()->route('staff.dashboard')->with('success', 'Welcome back, Staff!');
                case 'user':
                    return redirect()->route('user.dashboard')->with('success', 'Welcome back, User!');
                default:
                    return redirect()->route('dashboard')->with('success', 'Welcome back!');
            }
        } catch (\Exception $e) {
            Log::error('Error during login', ['error' => $e->getMessage()]);
            return back()->with('error', 'An error occurred. Please try again later.');
        }
    }

    public function logout(Request $request)
    {
        $userId = Auth::id();

        Log::info('Logout Request:', ['user_id' => $userId]);
        LogHelper::record('Logout', 'User berhasil logout.');

        Auth::logout();

        return redirect()->route('login')->with('success', 'Logged out successfully.');
    }

    public function showRegisterForm()
    {
        return view('auth.register');
    }

    public function register(Request $request)
    {
        Log::info('Register Request:', $request->all());

        $validator = Validator::make($request->all(), [
            'username' => 'required|string|max:255|unique:users',
            'email' => 'required|email|max:255|unique:users',
            'phone_number' => 'required|string|max:15|unique:users',
            'password' => 'required|min:6',
        ]);

        if ($validator->fails()) {
            Log::error('Validation Failed:', $validator->errors()->toArray());
            return back()->withErrors($validator)->withInput();
        }

        try {
            $user = User::create([
                'username' => $request->username,
                'email' => $request->email,
                'phone_number' => $request->phone_number,
                'password' => bcrypt($request->password),
            ]);

            Log::info('User registered successfully', ['user_id' => $user->id]);
            LogHelper::record('Register', 'User berhasil registrasi.');

            return redirect()->route('login')->with('success', 'Registration successful! Please log in.');
        } catch (\Exception $e) {
            Log::error('Error saving user', ['error' => $e->getMessage()]);
            return back()->with('error', 'An error occurred. Please try again.');
        }
    }
}
