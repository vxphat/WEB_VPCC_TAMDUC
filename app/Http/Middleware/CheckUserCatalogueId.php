<?php

namespace App\Http\Middleware;

use App\Models\User;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class CheckUserCatalogueId
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next)
    {
        $email = $request->input('email');   //Lấy giá trị email của người dùng nhập vào

        $user = User::where('email', $email)->first();   //Lấy ra dữ liệu của người dùng có email đã nhập

        if ($user->user_catalogue_id === 1) {    // Kiểm tra user_catalogue_id của người dùng
            return redirect()->route('auth.admin')->with('error', 'Bạn không có quyền truy cập');
        }

        if ($user->publish === 1) {
            return redirect()->route('auth.admin')->with('error', 'Tài khoản của bạn chưa được kích hoạt');
        }
        return $next($request);
    }
}
