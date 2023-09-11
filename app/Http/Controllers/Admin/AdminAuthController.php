<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class AdminAuthController extends Controller
{
    public function login() {
        if (Auth::guard('admin')->user()) {
            return redirect()->route('admin.blogs.index');
        }

        return view('admin.auth.login');
    }

    public function loginPost(Request $request) {
        $phone = $request->phone;
        $password = $request->password;

        if (Auth::guard('admin')->attempt(compact('phone', 'password'))) {
            return redirect()->route('admin.blogs.index')->with('message-success', 'Đăng nhập thành công!');
        } else {
            return redirect()->route('admin.login')->with('message', 'Sai tên đăng nhập hoặc mật khẩu');
        }
    }

    public function register(Request $request) {
        return view('admin.auth.register');
    }

    public function forgotPassword(Request $request) {
        return view('admin.auth.forgot-password');
    }

    // function logout
    public function logout() {
        auth('admin')->logout();

        return redirect()->route('admin.login');
    }
}
