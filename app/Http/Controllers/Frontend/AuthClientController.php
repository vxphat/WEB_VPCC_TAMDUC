<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Http\Requests\AuthClientRequest;
use App\Http\Requests\AuthRequests\ResetPasswordRequest;
use App\Models\PasswordReset;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AuthClientController extends Controller
{

    public function verifyEmail($token)
    {
        $user = User::where('email_verification_token', $token)->first();

        if ($user->created_at->addMinutes(60)->isPast()) {
            $user->delete();
            return redirect('/')->with('error', 'Yêu cầu đã hết hạn, vui lòng tạo lại tài khoản!');
        }

        $user->update([
            'email_verified_at' => Carbon::now(),
            //Một extension của PHP DateTime được sử dụng trong Laravel để làm việc với ngày giờ
            'publish' => 2,
            'email_verification_token' => null,
        ]);

        return redirect('/')->with('success', 'Kích hoạt tài khoản thành công, vui lòng đăng nhập!');
    }


    public function verifyPassword($token, $email)
    {
        $passReset = PasswordReset::where('password_verification_token', $token)->first();

        if ($passReset->created_at->addMinutes(60)->isPast()) {
            $passReset->delete();
            return redirect('/')->with('error', 'Yêu cầu đã hết hạn, vui lòng thực hiện lại yêu cầu!');
        }
        return view('frontend.auth.reset', compact('email'));
    }

    public function resetPassword(ResetPasswordRequest $request, $email)
    {
        $password = $request->input('password');
        User::where('email', $email)->update([
            'password' => Hash::make($password)
        ]);


        $passReset = PasswordReset::where('email', $email)->first();

        // if ($passReset->created_at->addMinutes(60)->isPast()) {
        //     $passReset->delete();
        //     return redirect('/')->with('error', 'Yêu cầu đã hết hạn, vui lòng thực hiện lại yêu cầu!');
        // }
        $passReset->delete();
        return redirect('/')->with('success', 'Đổi mật khẩu thành công, vui lòng đăng nhập lại!');
    }



    public function logout(Request $request)
    {
        Auth::logout();   //Đăng xuất người dùng hiện tại, xóa thông tin xác thực người dùng
        $request->session()->invalidate();     //Hủy session hiện tại của người dùng, xóa tất cả dữ liệu bao gồm ttdangnhap
        $request->session()->regenerateToken();         //Tái tạo CSRF mới cho Token
        return redirect()->route('home.index')->with('success', 'Đăng xuất thành công!');

    }
}
