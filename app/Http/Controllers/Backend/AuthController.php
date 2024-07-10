<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\Http\Requests\AuthRequest;
use Illuminate\Http\Request;

class AuthController extends Controller
{
    public function admin()
    {
        if (Auth::id() > 0) {
            //Kiểm tra nếu tồn tại id mới cho vào dashboard
            return redirect()->route('dashboard.index');
        }
        return view('backend.auth.login');
    }

    public function login(AuthRequest $request)
    {
        $credentials = [
            'email' => $request->input('email'),
            'password' => $request->input('password')
        ];    //Lấy mảng credential gồm email và password của người dùng đăng nhập

        if (Auth::attempt($credentials)) {      //Auth::attempt => Xác thực thông tin từ mảng người dùng nhập với db
            return redirect()->route('dashboard.index')->with('success', 'Đăng nhập thành công');
        }
        return redirect()->route('auth.admin')->with('error', 'Email hoặc Mật khẩu không chính xác');
    }

    public function logout(Request $request)
    {
        Auth::logout();   //Đăng xuất người dùng hiện tại, xóa thông tin xác thực người dùng
        $request->session()->invalidate();     //Hủy session hiện tại của người dùng, xóa tất cả dữ liệu bao gồm ttdangnhap
        $request->session()->regenerateToken();         //Tái tạo CSRF mới cho Token
        return redirect()->route('auth.admin')->with('success', 'Đăng xuất thành công');

    }
}
