<?php

namespace App\Helpers;

use App\Models\Log;
use Illuminate\Support\Facades\Auth;

class LogHelper
{
    public static function record(string $action, ?string $target = null)
    {
        $user = Auth::user();

        Log::create([
            'user_id' => $user?->id,
            'role'    => $user?->role,
            'action'  => $action,
            'target'  => $target,
        ]);
    }
}
