<?php

namespace App\Http\Controllers\Ajax;

use App\Http\Controllers\Controller;
use App\Http\Requests\AuthRequests\AuthClientRequest;
use App\Http\Requests\AuthRequests\RegisterRequest;
use App\Http\Requests\AuthRequests\sendMailRequest;
use App\Mail\RegisterMail;
use App\Mail\RePasswordMail;
use App\Mail\SendMail;
use App\Models\PasswordReset;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;

class AuthController extends Controller
{
    public function __construct()
    {

    }


    public function clientLogin(AuthClientRequest $request)
    {
        $option = $request->all();      //Nhận mảng option gồm tên đăng nhập và password
        $credentials = [
            'email' => $option['email'],
            'password' => $option['password']
        ];

        // Kiểm tra xem người dùng có tồn tại và `email_verification_token` không null
        $user = DB::table('users')
            ->where('email', $option['email'])
            ->whereNull('email_verification_token')
            ->first();

        if (!$user) {
            return response()->json([
                'code' => 1,
                'message' => 'Tài khoản chưa được xác nhận email!',
            ]);
        }

        if (Auth::attempt($credentials)) {      //Auth::attempt => Xác thực thông tin từ mảng người dùng nhập với db
            return response()->json([
                'code' => 0,
                'message' => 'Đăng nhập thành công!'
            ]);
            //Trả lại kết quả
        }
        return response()->json([
            'code' => 1,
            'message' => 'Có vấn đề xảy ra, hãy thử lại!',
        ]);
    }


    public function register(RegisterRequest $request)
    {
        $data = $request->all();
        $user = User::create([
            'name' => $data['name'],
            'email' => $data['email'],
            'password' => Hash::make($data['password']),
            'email_verification_token' => Str::random(60),
            'publish' => 1, // Giá trị mặc định
        ]);
        if ($user->exists) {
            //Thuộc tính exists của đối tượng $user sẽ trả về true nếu đối tượng đã được lưu trữ thành công trong cơ sở dữ liệu


            $link = route('register.confirm', ['token' => $user->email_verification_token]);
            // Gửi email xác nhận
            Mail::to($user->email)->send(new RegisterMail($link));

            return response()->json([
                'code' => 0,
                'message' => 'Đăng ký thành công! Vui lòng kiểm tra email để kích hoạt tài khoản.'
            ]);
        }

        return response()->json([
            'code' => 1,
            'message' => 'Có vấn đề xảy ra, hãy thử lại!',
        ]);
    }




    public function confirmPassword(sendMailRequest $request)
    {
        $email = $request->input('email');
        $user = DB::table('users')->where('email', $email)->first();

        if ($user) {
            $token = Str::random(60);

            PasswordReset::create([
                'email' => $email,
                'password_verification_token' => $token
            ]);

            $link = route('password.reset', ['token' => $token, 'email' => $email]);

            Mail::to($email)->send(new RePasswordMail($link));

            return response()->json([
                'code' => 0,
                'message' => 'Mã xác nhận đã được gửi đến mail của bạn!'
            ]);
            //Trả lại kết quả
        }
        return response()->json([
            'code' => 1,
            'message' => 'Có vấn đề xảy ra, hãy thử lại!',
        ]);
    }


}
