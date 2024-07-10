<?php

namespace App\Http\Middleware;

use App\Models\User;
use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Auth;

class AuthenticateMiddleware
{
    /**
     * Handle an incoming request.
     *  
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $user = User::where('id', Auth::id())->first();
        if (Auth::id() == null) {
            //Kiểm tra id người dùng xem đã đăng nhập chưa
            return redirect()->route('auth.admin')->with('error', 'Bạn phải đăng nhập để sử dụng chức năng này');
        }

        if ($user->user_catalogue_id === 1) {    // Kiểm tra user_catalogue_id của người dùng
            return redirect()->route('home.index')->with('error', 'Bạn không có quyền truy cập');
        }
        return $next($request);
    }
}
