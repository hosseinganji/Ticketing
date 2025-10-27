<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AdminMiddleware
{
    public function handle(Request $request, Closure $next, $level = null)
    {
        $user = Auth::user();

        if (!$user || $user->is_admin_level == 0) {
            abort(403, 'دسترسی غیرمجاز');
        }

        if ($level && $user->is_admin_level != $level) {
            abort(403, 'دسترسی غیرمجاز برای این سطح');
        }

        return $next($request);
    }
}
