<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\Models\Milestone;

class ProfileController extends Controller
{
    public function show()
    {
        $user = Auth::user();
        $milestones = Milestone::where('user_id', $user->id)->get();

        return view('user.profile', compact('user', 'milestones'));
    }
}
