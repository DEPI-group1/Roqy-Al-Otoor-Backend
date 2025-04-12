<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

class AdminMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next)
    {
        // if (!Auth::check() || !Auth::user()->isAdmin()) {
        //     return redirect('/')->with('error', 'ليس لديك الصلاحية للوصول إلى هذه الصفحة.');
        // }
        if (auth::check() && auth::user()->is_admin) {
            return $next($request);
        }

        // return redirect('/home');  // أو يمكنك إرسال رسالة أو تحويل المستخدم لصفح


        return $next($request);
    }
}